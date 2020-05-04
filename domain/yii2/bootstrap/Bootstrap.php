<?php

declare(strict_types=1);

namespace app\domain\yii2\bootstrap;

use app\domain\dispatchers\DummyEventDispatcher;
use app\domain\dispatchers\EventDispatcherInterface;
use app\domain\repositories\EmployeeRepositoryInterface;
use app\domain\yii2\repositories\Employee\SqlEmployeeRepository;
use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface {
	public function bootstrap($app) {
		(Yii::$container)->setSingletons([
			EventDispatcherInterface::class    => DummyEventDispatcher::class,
//			EmployeeRepositoryInterface::class => MemoryEmployeeRepository::class
			EmployeeRepositoryInterface::class => SqlEmployeeRepository::class
		]);
	}
}
