<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Implementations\Payment;

use app\domain\entities\Order\Decorators\DecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Payment\ValueObject\Payment;

interface PaymentDecoratorInterface extends DecoratorInterface {
	public function getPayment(): Payment;

	public function setPayment(Payment $payment): void;
}
