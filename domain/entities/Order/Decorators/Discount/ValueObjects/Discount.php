<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Discount\ValueObjects;

use Assert\Assertion;

class Discount {
	protected float  $price;
	protected string $name;

	public function __construct(
		float $price,
		string $name
	) {
		Assertion::notEmpty($price);
		Assertion::notEmpty($name);

		$this->price = $price;
		$this->name  = $name;
	}

	public function getPrice(): float {
		return $this->price;
	}

	public function getName(): string {
		return $this->name;
	}
}
