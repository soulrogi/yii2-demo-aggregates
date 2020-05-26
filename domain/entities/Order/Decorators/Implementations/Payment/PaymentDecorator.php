<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Implementations\Payment;

use app\domain\entities\Order\Decorators\CommonDecorator;
use app\domain\entities\Order\Decorators\Implementations\Payment\ValueObject\Payment;
use app\domain\entities\Order\OrderInterface;

class PaymentDecorator extends CommonDecorator implements PaymentDecoratorInterface {
	protected Payment $payment;

	public function __construct(OrderInterface $order) {
		$this->usedJustOnce($order,PaymentDecoratorInterface::class);

		parent::__construct($order);
	}

	public function getPayment(): Payment {
		return $this->payment;
	}

	public function setPayment(Payment $payment): void {
		$this->payment = $payment;
	}
}
