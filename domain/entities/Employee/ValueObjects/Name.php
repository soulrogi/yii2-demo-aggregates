<?php

declare(strict_types=1);

namespace app\domain\entities\Employee\ValueObjects;

use Assert\Assertion;

class Name {
	/** @var string  */
	protected $last;

	/** @var string  */
	protected $first;

	/** @var string|null  */
	protected $middle;

	public function __construct(
		string $last,
		string $first,
		?string $middle = null
	) {
		Assertion::notEmpty($last);
		Assertion::notEmpty($first);

		$this->last   = $last;
		$this->first  = $first;
		$this->middle = $middle;
	}

	public function getFull(): string {
		return trim($this->last . ' ' . $this->first . ' ' . $this->middle);
	}

	public function getLast(): string {
		return $this->last;
	}

	public function getFirst(): string {
		return $this->first;
	}

	public function getMiddle(): ?string {
		return $this->middle;
	}
}
