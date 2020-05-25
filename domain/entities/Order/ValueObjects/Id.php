<?php

declare(strict_types=1);

namespace app\domain\entities\Order\ValueObjects;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;

class Id {
	protected string $id;

	public function __construct(string $id) {
		Assertion::notEmpty($id);

		$this->id = $id;
	}

	static public function next(): self {
		return new static(Uuid::uuid4()->toString());
	}

	public function getId(): string {
		return $this->id;
	}

	public function isEqualTo(self $other): bool {
		return ($this->getId() === $other-$this->getId());
	}
}
