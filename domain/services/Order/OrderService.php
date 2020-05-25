<?php

declare(strict_types=1);

namespace app\domain\services\Order;

use app\domain\dispatchers\EventDispatcherInterface;
use app\domain\entities\Employee\Employee;
use app\domain\entities\Employee\ValueObjects\Address;
use app\domain\entities\Employee\ValueObjects\Id;
use app\domain\entities\Employee\ValueObjects\Name;
use app\domain\entities\Employee\ValueObjects\Phone;
use app\domain\entities\Order\Builder\Builder;
use app\domain\entities\Order\Builder\OrderDirector;
use app\domain\entities\Order\Order;
use app\domain\entities\Order\OrderInterface;
use app\domain\repositories\EmployeeRepositoryInterface;
use app\domain\services\Employee\dto\AddressDto;
use app\domain\services\Employee\dto\EmployeeArchiveDto;
use app\domain\services\Employee\dto\EmployeeCreateDto;
use app\domain\services\Employee\dto\EmployeeReinstateDto;
use app\domain\services\Employee\dto\NameDto;
use app\domain\services\Employee\dto\PhoneDto;
use DateTimeImmutable;

/**
 * Здесь сервис не особо большой и его действия совпадают с методами сущности.
 * Но могут быть и сервисы, оперирующие несколькими агрегатами.
 * Например, метод отправки этого сотрудника в командировку может не только
 * модифицировать сущность сотрудника, но и одновременно создавать сущность приказа
 * и заполнять сущность командировочного листа.
 *
 */
class OrderService {
	protected EventDispatcherInterface $dispatcher;

	public function __construct(EventDispatcherInterface $dispatcher) {
		$this->dispatcher = $dispatcher;
	}

	public function create(): OrderInterface {
//      todo Получить товары из корзы
//		todo Произвести запросы по АПИ всторонние сервисы
//		todo Выстовить резервы на товар
//		todo сопутствующие фиччи
//		todo создать заказ + заполнить его
//		todo Сохранить во временное хранилище

		$builder  = new Builder;
		$director = new OrderDirector;

		$director->createOrderWithDiscount($builder);

		$order = $builder->getOrder();

//		$this->repository->add($order);
		$this->dispatcher->dispatch($order->releaseEvents());

		return $order;
	}
}
