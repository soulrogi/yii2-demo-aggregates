<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Implementations\Payment;

use app\domain\entities\Order\Decorators\Implementations\Payment\ValueObject\Payment;
use app\domain\entities\Order\Decorators\Strategies\Unpacker\DecoratorUnpackerStrategyInterface;
use app\domain\entities\Order\OrderInterface;

class PaymentUnpackerStrategy implements DecoratorUnpackerStrategyInterface {
	/**
	 * @param OrderInterface|PaymentDecoratorInterface $order
	 *
	 * @return Payment
	 */
	public static function getPayloads(OrderInterface $order): Payment {
		return $order->getPayment();
	}
}
