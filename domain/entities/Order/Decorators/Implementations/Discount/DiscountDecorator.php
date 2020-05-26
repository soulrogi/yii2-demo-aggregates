<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Implementations\Discount;

use app\domain\entities\Order\Decorators\CommonDecorator;
use app\domain\entities\Order\Decorators\Implementations\Discount\ValueObjects\Discount;
use app\domain\entities\Order\OrderInterface;
use app\domain\entities\Order\ValueObjects\Price;

class DiscountDecorator extends CommonDecorator implements DiscountDecoratorInterface {
	protected Discount $discount;

	public function __construct(
		OrderInterface $order,
		Discount $discount
	) {
		$this->discount = $discount;

		parent::__construct($order);
	}

	public function getPrice(): Price {
		return new Price(parent::getPrice()->getValue() - $this->discount->getPrice());
	}

	public function getDiscountPrice(): float {
		return $this->discount->getPrice();
	}

	public function getDiscountName(): string {
		return $this->discount->getName();
	}

	public function getDiscount(): Discount {
		return $this->discount;
	}

	public static function getPercentageOfNumber(OrderInterface $order, float $percent): float {
		return round($order->getPrice()->getValue() * ($percent / 100), 2);
	}
}
