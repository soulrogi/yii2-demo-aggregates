<?php

declare(strict_types=1);

namespace app\domain\entities\Order\ValueObjects;

use Assert\Assertion;
use DateTimeImmutable;

class Price {
	protected float $value;

	public function __construct(float $value) {
		Assertion::notEmpty($value);

		$this->value = $value;
	}

	public function getValue(): float {
		return $this->value;
	}
}
