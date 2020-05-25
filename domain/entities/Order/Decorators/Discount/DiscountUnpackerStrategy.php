<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Discount;

use app\domain\entities\Order\Decorators\DecoratorUnpackerStrategyInterface;
use app\domain\entities\Order\Decorators\Discount\ValueObjects\Discount;
use app\domain\entities\Order\OrderInterface;

class DiscountUnpackerStrategy implements DecoratorUnpackerStrategyInterface {
	/**
	 * @param OrderInterface|DiscountDecorator $order
	 *
	 * @return Discount
	 */
	public static function getPayloads(OrderInterface $order) {
		return $order->getDiscount();
	}
}
