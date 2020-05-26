<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Implementations\Discount;

use app\domain\entities\Order\Decorators\DecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Discount\ValueObjects\Discount;

interface DiscountDecoratorInterface extends DecoratorInterface {
	public function getDiscountPrice(): float;

	public function getDiscountName(): string;

	public function getDiscount(): Discount;
}
