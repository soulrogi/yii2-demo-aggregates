<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Implementations\Delivery;

use app\domain\entities\Order\Decorators\DecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Delivery\ValueObjects\Delivery;

interface DeliveryDecoratorInterface extends DecoratorInterface {
	public function setDelivery(Delivery $delivery): void;

	public function getDelivery(): Delivery;
}
