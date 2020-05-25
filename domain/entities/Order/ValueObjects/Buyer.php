<?php

declare(strict_types=1);

namespace app\domain\entities\Order\ValueObjects;

use Assert\Assertion;

class Buyer {
	protected string $id;

	public function __construct(string $id) {
		Assertion::notEmpty($id);

		$this->id = $id;
	}

	public function getId(): string {
		return $this->id;
	}
}
