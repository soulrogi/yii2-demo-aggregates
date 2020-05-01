<?php

declare(strict_types=1);

namespace app\entities\Employee\ValueObjects;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;

class Id {
	/** @var string Id */
	protected $id;

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
