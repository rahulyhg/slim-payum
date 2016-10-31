<?php
namespace AppMain\Migration;
require_once 'public/prepare.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration {
	/** @var \Illuminate\Database\Capsule\Manager $capsule */
	public $capsule;
	/** @var \Illuminate\Database\Schema\Builder $capsule */
	public $schema;

	public function init() {
		$this->capsule = new Capsule;
		$dbSettings = $appSettings['db'];
		$this->capsule->addConnection([
			'driver' => getenv('DB_DRIVER'),
			'host' => getenv('DB_HOST'),
			'database' => getenv('DB_DATABASE'),
			'username' => getenv('DB_USERNAME'),
			'password' => getenv('DB_PASSWORD'),
			'charset' => getenv('DB_CHARSET'),
			'collation' => getenv('DB_COLLATION'),
			'prefix' => getenv('DB_PREFIX'),
		]);

		$this->capsule->bootEloquent();
		$this->capsule->setAsGlobal();
		$this->schema = $this->capsule->schema();
	}
}