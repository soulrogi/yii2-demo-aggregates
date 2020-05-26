<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Implementations\Discount;

use app\domain\entities\Order\Decorators\Implementations\Discount\ValueObjects\Discount;
use app\domain\entities\Order\Decorators\Strategies\Unpacker\DecoratorUnpackerStrategyInterface;
use app\domain\entities\Order\OrderInterface;

class DiscountUnpackerStrategy implements DecoratorUnpackerStrategyInterface {
	/**
	 * @param OrderInterface|DiscountDecoratorInterface $order
	 *
	 * @return Discount
	 */
	public static function getPayloads(OrderInterface $order): Discount {
		return $order->getDiscount();
	}
}
