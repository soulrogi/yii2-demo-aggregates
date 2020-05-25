<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Delivery;

use app\domain\entities\Order\Decorators\DecoratorUnpackerStrategyInterface;
use app\domain\entities\Order\Decorators\Delivery\ValueObjects\Delivery;
use app\domain\entities\Order\OrderInterface;

class DeliveryUnpackerStrategy implements DecoratorUnpackerStrategyInterface {
	/**
	 * @param OrderInterface|DeliveryDecorator $order
	 *
	 * @return Delivery
	 */
	public static function getPayloads(OrderInterface $order): Delivery {
		return $order->getDelivery();
	}
}
