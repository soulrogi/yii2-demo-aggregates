<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Builder;

use app\domain\entities\Order\Decorators\Delivery\ValueObjects\Delivery;
use app\domain\entities\Order\Decorators\Discount\ValueObjects\Discount;
use app\domain\entities\Order\Decorators\Payment\ValueObject\Payment;
use app\domain\entities\Order\ValueObjects\Buyer;
use app\domain\entities\Order\ValueObjects\Goods;
use app\domain\entities\Order\ValueObjects\Item;
use app\domain\entities\Order\ValueObjects\Price;
use Ramsey\Uuid\Uuid;

class OrderDirector {
	public function createBasicOrder(BuilderInterface $builder): void {
		$builder
			->addBuyer(new Buyer(Uuid::uuid4()->toString()))
			->addPrice(new Price(990.880))
			->addGoods(new Goods([
				new Item(Uuid::uuid4()->toString(), 4),
				new Item(Uuid::uuid4()->toString(), 1),
				new Item('e691b6ee-fe47-42d7-81c7-0794593f29f6', 3),
				new Item(Uuid::uuid4()->toString(), 1),
			]))
			->addDelivery(new Delivery(Uuid::uuid4()->toString()))
			->addPayment(new Payment(Uuid::uuid4()->toString()))
		;
	}

	public function createOrderWithDiscount(BuilderInterface $builder): void {
		$this->createBasicOrder($builder);

		$builder->addDiscount(new Discount(8, 'March 8'));
	}


}
