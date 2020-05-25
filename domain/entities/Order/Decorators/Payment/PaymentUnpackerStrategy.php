<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Payment;

use app\domain\entities\Order\Decorators\DecoratorUnpackerStrategyInterface;
use app\domain\entities\Order\Decorators\Payment\ValueObject\Payment;
use app\domain\entities\Order\OrderInterface;

class PaymentUnpackerStrategy implements DecoratorUnpackerStrategyInterface {
	/**
	 * @param OrderInterface|PaymentDecoratorInterface $order
	 *
	 * @return Payment
	 */
	public static function getPayloads(OrderInterface $order) {
		return $order->getPayment();
	}
}
