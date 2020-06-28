<?php

declare(strict_types=1);

namespace app\domain\services\Order\OrderCreation;

use app\domain\dispatchers\EventDispatcherInterface;
use app\domain\entities\Order\Builder\Builder;
use app\domain\entities\Order\Builder\OrderDirector;
use app\domain\entities\Order\Decorators\Implementations\Discount\ValueObjects\Discount;
use app\domain\entities\Order\OrderInterface;

/**
 * Здесь сервис не особо большой и его действия совпадают с методами сущности.
 * Но могут быть и сервисы, оперирующие несколькими агрегатами.
 * Например, метод отправки этого сотрудника в командировку может не только
 * модифицировать сущность сотрудника, но и одновременно создавать сущность приказа
 * и заполнять сущность командировочного листа.
 *
 */
class OrderCreationService {
	protected EventDispatcherInterface $dispatcher;

	public function __construct(EventDispatcherInterface $dispatcher) {
		$this->dispatcher = $dispatcher;
	}

	public function create(): OrderInterface {
//      todo Получить товары из корзы
//		todo Произвести запросы по АПИ в сторонние сервисы
//		todo Выстовить резервы на товар
//		todo сопутствующие фиччи
//		todo создать заказ + заполнить его
//		todo Сохранить во временное хранилище

		$builder  = new Builder; // у билдера должныбыть все интрументы для строительства заказа, Прокинуть через конструктор

		OrderDirector::orderWithSeveralDiscount($builder);

		$builder->addDiscount(
			new Discount(100, 'New Year2!!!')
		);

		$order = $builder->getOrder();

//		$this->repository->add($order);
		$this->dispatcher->dispatch($order->releaseEvents());

		return $order;
	}
}
