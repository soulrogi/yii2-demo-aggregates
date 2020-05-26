<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Implementations\Delivery;

use app\domain\entities\Order\Decorators\Implementations\Delivery\ValueObjects\Delivery;
use app\domain\entities\Order\Decorators\Strategies\Unpacker\DecoratorUnpackerStrategyInterface;
use app\domain\entities\Order\OrderInterface;

class DeliveryUnpackerStrategy implements DecoratorUnpackerStrategyInterface {
	/**
	 * @param OrderInterface|DeliveryDecoratorInterface $order
	 *
	 * @return Delivery
	 */
	public static function getPayloads(OrderInterface $order): Delivery {
		return $order->getDelivery();
	}
}
