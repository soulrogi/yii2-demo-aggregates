<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Builder;

use app\domain\entities\Order\Decorators\Implementations\Delivery\ValueObjects\Delivery;
use app\domain\entities\Order\Decorators\Implementations\Discount\ValueObjects\Discount;
use app\domain\entities\Order\Decorators\Implementations\Payment\ValueObject\Payment;
use app\domain\entities\Order\ValueObjects\Buyer;
use app\domain\entities\Order\ValueObjects\Goods;
use app\domain\entities\Order\ValueObjects\Item;
use app\domain\entities\Order\ValueObjects\Price;
use Ramsey\Uuid\Uuid;

class OrderDirector {
	public static function basicOrder(BuilderInterface $builder): void {
		$builder->addBuyer(new Buyer(Uuid::uuid4()->toString()));
		$builder->addPrice(new Price(990.880));
		$builder->addGoods(new Goods([
			new Item(Uuid::uuid4()->toString(), 4),
			new Item(Uuid::uuid4()->toString(), 1),
			new Item('e691b6ee-fe47-42d7-81c7-0794593f29f6', 3),
			new Item(Uuid::uuid4()->toString(), 1),
		]));
		$builder->addDelivery(new Delivery(Uuid::uuid4()->toString()));
		$builder->addPayment(new Payment(Uuid::uuid4()->toString()));
	}

	public static function orderWithDiscount(BuilderInterface $builder): void {
		static::basicOrder($builder);

		$builder->addDiscount(new Discount(8, 'March 8'));
	}

	public static function orderWithSeveralDiscount(BuilderInterface $builder): void {
		static::basicOrder($builder);

		$builder->addDiscount(new Discount(8, 'March 8'));
		$builder->addDiscount(new Discount(10, 'New Year!!!'));
	}
}
