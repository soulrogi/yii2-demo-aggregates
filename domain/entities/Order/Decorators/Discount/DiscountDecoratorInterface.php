<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Discount;

use app\domain\entities\Order\Decorators\DecoratorInterface;
use app\domain\entities\Order\Decorators\Discount\ValueObjects\Discount;
use app\domain\entities\Order\OrderInterface;

interface DiscountDecoratorInterface extends OrderInterface, DecoratorInterface {
	public function getDiscountPrice(): float;

	public function getDiscountName(): string;

	public function getDiscount(): Discount;
}
