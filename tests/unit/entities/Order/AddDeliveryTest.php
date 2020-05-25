<?php

declare(strict_types=1);

namespace app\tests\unit\entities\Order;

use app\domain\entities\Order\Decorators\Discount\DiscountDecorator;
use app\domain\entities\Order\Decorators\Discount\ValueObjects\Discount;
use app\domain\entities\Order\Decorators\Payment\PaymentDecorator;
use app\domain\entities\Order\Decorators\Payment\ValueObject\Payment;
use app\domain\entities\Order\Order;
use app\domain\entities\Order\ValueObjects\Buyer;
use app\domain\entities\Order\ValueObjects\Goods;
use app\domain\entities\Order\ValueObjects\Id;
use app\domain\entities\Order\ValueObjects\Item;
use app\domain\entities\Order\ValueObjects\Price;
use Codeception\Test\Unit;
use Ramsey\Uuid\Uuid;

class AddDeliveryTest extends Unit {
	public function testSuccess(): void {
		$order = new Order(
			Id::next(),
			new Price(99.88),
			new Goods([
				new Item(Uuid::uuid4()->toString(), 4),
				new Item(Uuid::uuid4()->toString(), 1),
				new Item(Uuid::uuid4()->toString(), 3),
				new Item(Uuid::uuid4()->toString(), 1),
			]),
			new Buyer(Uuid::uuid4()->toString())
		);
	}
}
