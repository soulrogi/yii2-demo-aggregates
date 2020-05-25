<?php

declare(strict_types=1);

namespace app\tests\unit\entities\Order;

use app\domain\entities\Order\Decorators\Discount\DiscountDecorator;
use app\domain\entities\Order\Decorators\Discount\ValueObjects\Discount;
use app\domain\entities\Order\Order;
use app\domain\entities\Order\ValueObjects\Buyer;
use app\domain\entities\Order\ValueObjects\Goods;
use app\domain\entities\Order\ValueObjects\Id;
use app\domain\entities\Order\ValueObjects\Item;
use app\domain\entities\Order\ValueObjects\Price;
use Codeception\Test\Unit;
use Ramsey\Uuid\Uuid;

class addDiscountTest extends Unit {
	public function testOneSuccess(): void {
		$order = new Order(
			Id::next(),
			$price = new Price(99.88),
			new Goods([
				new Item(Uuid::uuid4()->toString(), 4),
				new Item(Uuid::uuid4()->toString(), 1),
				new Item(Uuid::uuid4()->toString(), 3),
				new Item(Uuid::uuid4()->toString(), 1),
			]),
			new Buyer(Uuid::uuid4()->toString())
		);

		$this->assertEquals($price, $order->getPrice()); // Check cost

		//region -- Add discount
		$discountPrice = DiscountDecorator::getPercentageOfNumber($order, 8);
		$name          = 'March 8';
		$discountOrder = new DiscountDecorator($order, new Discount($discountPrice, $name));

		$this->assertEquals($name, $discountOrder->getDiscountName());
		$this->assertEquals($discountPrice, $discountOrder->getDiscountPrice());
		$this->assertEquals($price->getValue() - $discountPrice, $discountOrder->getPrice()->getValue());
		//endregion
	}

	public function testSeveralDiscounts(): void {
		$order = new Order(
			Id::next(),
			$price = new Price(99.88),
			new Goods([
				new Item(Uuid::uuid4()->toString(), 4),
				new Item(Uuid::uuid4()->toString(), 1),
				new Item(Uuid::uuid4()->toString(), 3),
				new Item(Uuid::uuid4()->toString(), 1),
			]),
			new Buyer(Uuid::uuid4()->toString())
		);

		$this->assertEquals($price, $order->getPrice()); // Check cost

		//region -- Add first discount
		$discountPrice = DiscountDecorator::getPercentageOfNumber($order, 8);
		$name          = 'March 8';
		$discountFirst = new DiscountDecorator($order, new Discount($discountPrice, $name));

		$this->assertEquals($name, $discountFirst->getDiscountName());
		$this->assertEquals($discountPrice, $discountFirst->getDiscountPrice());
		$this->assertEquals(
			$price->getValue() - $discountPrice,
			$discountFirst->getPrice()->getValue()
		);
		//endregion

		//region -- Add second discount
		$discountPrice  = DiscountDecorator::getPercentageOfNumber($discountFirst, 10);
		$name           = 'New Year!';
		$discountSecond = new DiscountDecorator($discountFirst, new Discount($discountPrice, $name));

		$this->assertEquals($name, $discountSecond->getDiscountName());
		$this->assertEquals($discountPrice, $discountSecond->getDiscountPrice());
		$this->assertEquals(
			$discountFirst->getPrice()->getValue() - $discountPrice,
			$discountSecond->getPrice()->getValue()
		);
		//endregion
	}
}
