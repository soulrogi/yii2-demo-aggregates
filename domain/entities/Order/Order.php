<?php

declare(strict_types=1);

namespace app\domain\entities\Order;

use app\domain\entities\EventTrait;
use app\domain\entities\Order\Events\OrderCreated;
use app\domain\entities\Order\ValueObjects\Buyer;
use app\domain\entities\Order\ValueObjects\Goods;
use app\domain\entities\Order\ValueObjects\Id;
use app\domain\entities\Order\ValueObjects\Price;

/**
 * Конкретные Компоненты предоставляют реализации поведения по умолчанию. Может
 * быть несколько вариаций этих классов.
 */
final class Order implements OrderInterface {
	use EventTrait;

	protected Id    $id;
	protected Price $price;
	protected Goods $goods;
	protected Buyer $buyer;

	public function __construct(
		Id $id,
		Price $price,
		Goods $goods,
		Buyer $buyer
	) {
		$this->id    = $id;
		$this->price = $price;
		$this->goods = $goods;
		$this->buyer = $buyer;

		$this->recordEvent(new OrderCreated($this->id));
	}

	public function getId(): Id {
		return $this->id;
	}

	public function getPrice(): Price {
		return $this->price;
	}

	public function getGoods(): Goods {
		return $this->goods;
	}

	public function getBuyer(): Buyer {
		return $this->buyer;
	}
}
