<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Delivery\ValueObjects;

class Delivery {
	protected string $id;

	public function __construct(string $id) {
		$this->id = $id;
	}

	public function getId(): string {
		return $this->id;
	}
}
