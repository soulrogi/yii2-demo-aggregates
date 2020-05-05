<?php

declare(strict_types=1);

namespace app\domain\yii2\bootstrap;

use app\domain\dispatchers\DummyEventDispatcher;
use app\domain\dispatchers\EventDispatcherInterface;
use app\domain\repositories\EmployeeRepositoryInterface;
use app\domain\repositories\Hydrator;
use app\domain\yii2\repositories\Employee\SqlEmployeeRepository;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use Yii;
use yii\base\BootstrapInterface;
use yii\di\Instance;

class Bootstrap implements BootstrapInterface {
	protected const INSTANCE_DB = 'db';

	public function bootstrap($app) {
		$container = Yii::$container;

		$container->setSingleton(Hydrator::class);

		$container->setSingleton(LazyLoadingValueHolderFactory::class);

		$container->setSingleton(static::INSTANCE_DB, function() use ($app) {
			return $app->db;
		});

		$container->setSingleton(
			EventDispatcherInterface::class,
			DummyEventDispatcher::class
		);

		$container->setSingleton(
			EmployeeRepositoryInterface::class,
			SqlEmployeeRepository::class,
			[Instance::of(static::INSTANCE_DB)]
		);
	}
}
