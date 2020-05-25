<?php

declare(strict_types=1);

namespace app\tests\unit\entities\Order;

use app\domain\entities\Order\Exceptions\DoesNotContainGoodsException;
use app\domain\entities\Order\Order;
use app\domain\entities\Order\ValueObjects\Buyer;
use app\domain\entities\Order\ValueObjects\Goods;
use app\domain\entities\Order\ValueObjects\Id;
use app\domain\entities\Order\ValueObjects\Item;
use app\domain\entities\Order\ValueObjects\Price;
use Codeception\Test\Unit;
use Ramsey\Uuid\Uuid;

class CreateTest extends Unit {
	public function testSuccess(): void {
		$order = new Order(
			$id    = Id::next(),
			$price = new Price(990.880),
			$goods = new Goods([
				new Item(Uuid::uuid4()->toString(), 4),
				new Item(Uuid::uuid4()->toString(), 1),
				new Item(Uuid::uuid4()->toString(), 3),
				new Item(Uuid::uuid4()->toString(), 1),
			]),
			$buyer = new Buyer(Uuid::uuid4()->toString())
		);

		$this->assertEquals($id, $order->getId());
		$this->assertEquals($price, $order->getPrice());
		$this->assertEquals($goods, $order->getGoods());
		$this->assertEquals($buyer, $order->getBuyer());
	}

	public function testWithoutGoods(): void {
		$this->expectException(DoesNotContainGoodsException::class);

		new Order(
			$id    = Id::next(),
			$price = new Price(990.880),
			$goods = new Goods([]),
			$buyer = new Buyer(Uuid::uuid4()->toString())
		);
	}
}
