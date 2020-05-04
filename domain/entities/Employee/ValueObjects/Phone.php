<?php

declare(strict_types=1);

namespace app\domain\entities\Employee\ValueObjects;

use Assert\Assertion;

class Phone {
	protected int $country;
	protected string $code;
	protected string $number;

	public function __construct(
		int $country,
		string $code,
		string $number
	) {
		Assertion::notEmpty($country);
		Assertion::notEmpty($code);
		Assertion::notEmpty($number);

		$this->country = $country;
		$this->code    = $code;
		$this->number  = $number;
	}

	public function isEqualTo(self $phone): bool {
		return ($this->getFull() === $phone->getFull());
	}

	public function getFull(): string {
		return trim('+' . $this->country . ' (' . $this->code . ') ' . $this->number);
	}

	public function getCountry(): int {
		return $this->country;
	}

	public function getCode(): string {
		return $this->code;
	}

	public function getNumber(): string {
		return $this->number;
	}
}
