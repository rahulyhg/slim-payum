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
			$settings = $c->get('settings')['Applogger'];
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

		$container['db'] = function ($c) {
			$capsule = new \Illuminate\Database\Capsule\Manager;
			$capsule->addConnection($c['settings']['db']);

			return $capsule;
		};

		// init eloquent
		$capsule = $container->db;
		$capsule->setAsGlobal();
		$capsule->bootEloquent();

		$container['payum'] = function ($c) {
			$builder = new \Payum\Core\PayumBuilder();
			$builder->setTokenStorage(new \AppMain\Storage\TokenMemoryStorage(\AppMain\Model\TokenModel::class))
				->setGatewayConfigStorage(new \AppMain\Storage\GatewayConfigContainerStorage(\AppMain\Model\GatewayConfigModel::class, $c));

			// this is helpful if you want to setup the Payum recommended multi-step Token payment setup
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
	}

	/**
	 * {@inheritdoc}
	 */
	public function initMiddlewares(\SlimDash\Core\SlimDashApp $app) {
		// check for roles
	}

	/**
	 * {@inheritdoc}
	 */
	public function initRoutes(\SlimDash\Core\SlimDashApp $app) {

		// set default url right now
		$homeCtrl = \AppMain\Controller\HomeController::class;

		// var_dump($ctrl);
		$app->route(['get'], '/', $homeCtrl, 'Home')->setName('home');
		$app->group('/api/payment', function () {
			$paymentCtrl = \AppMain\Controller\PaymentController::class;
			$this->route(['POST'], '/charge', $paymentCtrl, 'Charge')->setName('payment.charge');

			// this is helpful if you want to setup the Payum recommended multi-step Token payment setup
			/*
			$this->route(['POST'], '/prepare', $paymentCtrl, 'Prepare')->setName('payment.prepare');
			$this->route(['GET'], '/done/{payum_token}', $paymentCtrl, 'Done')->setName('payment.done');
			$this->route(['GET'], '/authorize/{payum_token}', $paymentCtrl, 'Authorize')->setName('payment.authorize');
			$this->route(['GET'], '/capture/{payum_token}', $paymentCtrl, 'Capture')->setName('payment.capture');
			$this->route(['GET'], '/notify/{payum_token}', $paymentCtrl, 'Notify')->setName('payment.notify');
			$this->route(['GET'], '/cancel/{payum_token}', $paymentCtrl, 'Cancel')->setName('payment.cancel');
			$this->route(['GET'], '/refund/{payum_token}', $paymentCtrl, 'Refund')->setName('payment.refund');
			$this->route(['GET'], '/payout/{payum_token}', $paymentCtrl, 'Payout')->setName('payment.payout');
			*/
		});
	}
}