<?php

declare(strict_types=1);

namespace app\domain\entities\Employee\ValueObjects;

use Assert\Assertion;
use DateTimeImmutable;

class Status {
	const ACTIVE   = 'active';
	const ARCHIVED = 'archived';

	const VALUE = 'value';
	const DATE  = 'date';

	protected string $value;
	protected DateTimeImmutable $date;

	public function __construct(
		string $value,
		DateTimeImmutable $date
	) {
		Assertion::inArray($value, [
			static::ACTIVE,
			static::ARCHIVED,
		]);

		$this->value = $value;
		$this->date  = $date;
	}

	public function isActive(): bool {
		return (static::ACTIVE === $this->value);
	}

	public function isArchived(): bool {
		return (static::ARCHIVED === $this->value);
	}

	public function getValue(): string {
		return $this->value;
	}

	public function getDate(): DateTimeImmutable {
		return $this->date;
	}
}
