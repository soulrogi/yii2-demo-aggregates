<?php


namespace app\domain\entities\Order\ValueObjects;


class Item {
	protected string $id;
	protected int    $quantity;

	public function __construct(
		string $id,
		int $quantity
	) {
		$this->id       = $id;
		$this->quantity = $quantity;
	}

	public function getId(): string {
		return $this->id;
	}

	public function getQuantity(): int {
		return $this->quantity;
	}

	public function setQuantity(int $quantity): void {
		$this->quantity = $quantity;
	}

	public function isEqualTo(self $item): bool {
		return $this->getId() === $item->getId();
	}
}
