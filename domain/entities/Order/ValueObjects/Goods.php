<?php

namespace app\domain\entities\Order\ValueObjects;

use app\domain\entities\Employee\Exceptions\ContainAtLeastOnePhoneException;
use app\domain\entities\Employee\Exceptions\PhoneAlreadyExistsException;
use app\domain\entities\Order\Exceptions\DoesNotContainGoodsException;
use app\domain\entities\Order\Exceptions\ItemIsNotFoundException;
use DomainException;
use Ramsey\Uuid\Uuid;

class Goods {
	/** @var Item[]  */
	protected array $items = [];

	public function __construct(array $items) {
		if ([] === $items) {
			throw new DoesNotContainGoodsException;
		}

		foreach ($items as $phone) {
			$this->add($phone);
		}
	}

	public function add(Item $item): void {
		foreach ($this->items as $current) {
			if ($current->isEqualTo($item)) {
				$current->setQuantity($current->getQuantity() + $item->getQuantity());
			}
		}

		$this->items[Uuid::uuid4()->toString()] = $item;
	}

	public function remove(string $id): Item {
		$items = array_filter($this->items, function(Item $item) use ($id): bool {
			return $item->getId() === $id;
		});

		if ([] === $items) {
			throw new ItemIsNotFoundException;
		}

		foreach (array_keys($items) as $key) {
			unset($this->items[$key]);
		}

		return end($items);
	}

	public function getAll(): array {
		return $this->items;
	}
}
