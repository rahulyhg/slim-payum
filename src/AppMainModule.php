<?php
namespace AppMain;
use SlimDash\Core;

class AppMainModule extends \SlimDash\Core\SlimDashModule {
	/**
	 * {@inheritdoc}
	 */
	public function initDependencies(\SlimDash\Core\SlimDashApp $app) {
		$container = $app->getContainer();
		$settings = $container->get('settings');

		// view renderer
		$container['renderer'] = function ($c) {
			// we will add folders after instatiation so that we can assign IDs
			$settings = $c->get('settings')['renderer'];
			$folders = $settings['folders'];
			unset($settings['folders']);

			$twigExtra = [];
			if (isset($settings['cache'])) {
				$parms['cache'] = $settings['cache'];
			}
			$view = new \Slim\Views\Twig($folders, $twigExtra);

			// Instantiate and add Slim specific extension
			$basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');

			// Twig extension
			$view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));
			$view->addExtension(new \Twig_Extension_Debug());

			return $view;
		};

		// monolog
		$container['logger'] = function ($c) {
			$settings = $c->get('settings')['logger'];
			$logger = new \Monolog\Logger($settings['name']);
			$logger->pushProcessor(new \Monolog\Processor\UidProcessor());
			$logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
			return $logger;
		};

		$container['session'] = function ($c) {
			$settings = $c->get('settings')['session'];

			$session_factory = new \Aura\Session\SessionFactory;
			$session = $session_factory->newInstance($_COOKIE);

			return $session->getSegment($settings['namespace']);
		};

		$container['payum'] = function ($c) {
			$builder = new \AppMain\MyPayumBuilder();
			$builder->setTokenStorage(
				new \AppMain\Storage\TokenMemoryStorage(\AppMain\Model\TokenModel::class))
				->setGatewayConfigStorage(
					new \AppMain\Storage\GatewayConfigContainerStorage(
						\AppMain\Model\GatewayConfigModel::class, $c));

			// add custom gateway factory
			$builder->addGatewayFactory('payeezy', function (array $config, $coreGatewayFactory) {
				return new \Payum\Payeezy\PayeezyGatewayFactory($config, $coreGatewayFactory);
			});

			// this is helpful if you want Payum recommended multi-step Token setup
			/*
			$builder->setTokenFactory(function ($tokenStorage, $registry) use ($c) {
				return new \AppMain\TokenFactory($tokenStorage, $registry, $c);
			});

			$builder->setGenericTokenFactoryPaths(array(
				'capture' => 'payment.capture',
				'notify' => 'payment.notify',
				'authorize' => 'payment.authorize',
				'refund' => 'payment.refund',
				'payout' => 'payment.payout',
			));
			*/

			return $builder->getPayum();
		};

		$container['db'] = function ($c) {
			$capsule = new \Illuminate\Database\Capsule\Manager;
			$capsule->addConnection($c['settings']['db']);

			return $capsule;
		};

		// finally, init eloquent if you want to use it for storage
		/*
		$capsule = $container->db;
		$capsule->setAsGlobal();
		$capsule->bootEloquent();
		*/
	}

	/**
	 * {@inheritdoc}
	 */
	public function initMiddlewares(\SlimDash\Core\SlimDashApp $app) {
		// a good place to check for roles
	}

	/**
	 * {@inheritdoc}
	 */
	public function initRoutes(\SlimDash\Core\SlimDashApp $app) {

		// set default url right now
		$homeCtrl = \AppMain\Controller\HomeController::class;
		$app->route(['get'], '/', $homeCtrl, 'Home')->setName('home');

		// setup payment url
		$app->group('/api/payment', function () {
			$paymentCtrl = \AppMain\Controller\PaymentController::class;

			$this->route(['POST'], '/authorize', $paymentCtrl, 'Authorize')
				->setName('payment.authorize');
			$this->route(['POST'], '/capture', $paymentCtrl, 'Capture')
				->setName('payment.capture');
			$this->route(['POST'], '/cancel', $paymentCtrl, 'Cancel')
				->setName('payment.cancel');
			$this->route(['POST'], '/refund', $paymentCtrl, 'Refund')
				->setName('payment.refund');
		});
	}
}