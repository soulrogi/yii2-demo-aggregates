<?php

declare(strict_types=1);

namespace app\domain\providers\Order;

use app\domain\entities\Order\Decorators\Helpers\DecoratorUnpacker;
use app\domain\providers\ProviderInterface;
use app\domain\providers\ProviderTreit;
use app\domain\services\Order\OrderCreation\dto\OrderCreationDto;
use app\domain\services\Order\OrderCreation\OrderCreationService;
use DomainException;

class OrderProvider implements ProviderInterface {
	use ProviderTreit;

	protected OrderCreationService $service;

	public function __construct(OrderCreationService $orderService) {
		$this->service = $orderService;
	}

	public function creat(OrderCreationDto $dto): bool {
		try {
			$order      = $this->service->create();
			$items      = $order->getGoods()->remove('e691b6ee-fe47-42d7-81c7-0794593f29f6');
			$unpacker   = new DecoratorUnpacker($order);
			$discounts  = $unpacker->getDiscounts();
			$deliveries = $unpacker->getDeliveries();

			$this->payload = [
				'FormDto'        => $dto,
				'OrderId'        => $order->getId()->getId(),
				'Removed Item'   => $items->getId(),
				'DiscountsNames' => $discounts,
				'DeliveryId'     => end($deliveries)->getId(),
			];

			return true;
		}
		catch (DomainException $e) {
			$this->errors = [$e->getMessage()];

			return false;
		}
	}
}
