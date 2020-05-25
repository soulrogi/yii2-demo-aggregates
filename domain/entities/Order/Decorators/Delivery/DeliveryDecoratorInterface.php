<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Delivery;

use app\domain\entities\Order\Decorators\DecoratorInterface;
use app\domain\entities\Order\Decorators\Delivery\ValueObjects\Delivery;
use app\domain\entities\Order\OrderInterface;

interface DeliveryDecoratorInterface extends OrderInterface, DecoratorInterface {
	public function setDelivery(Delivery $delivery): void;

	public function getDelivery(): Delivery;
}
