<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Delivery;

use app\domain\entities\Order\Decorators\CommonDecorator;
use app\domain\entities\Order\Decorators\Delivery\ValueObjects\Delivery;
use app\domain\entities\Order\OrderInterface;

class DeliveryDecorator extends CommonDecorator implements DeliveryDecoratorInterface {
	protected Delivery $delivery;

	public function __construct(OrderInterface $order) {
		$this->usedJustOnce($order,DeliveryDecoratorInterface::class,);

		parent::__construct($order);
	}

	public function setDelivery(Delivery $delivery): void {
		$this->delivery = $delivery;
	}

	public function getDelivery(): Delivery {
		return $this->delivery;
	}
}
