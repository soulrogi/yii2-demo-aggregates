<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Payment;

use app\domain\entities\Order\Decorators\DecoratorInterface;
use app\domain\entities\Order\Decorators\Payment\ValueObject\Payment;
use app\domain\entities\Order\OrderInterface;

interface PaymentDecoratorInterface extends OrderInterface, DecoratorInterface {
	public function getPayment(): Payment;

	public function setPayment(Payment $payment): void;
}
