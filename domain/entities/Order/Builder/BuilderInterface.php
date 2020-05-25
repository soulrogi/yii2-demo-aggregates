<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Builder;

use app\domain\entities\Order\Decorators\Delivery\ValueObjects\Delivery;
use app\domain\entities\Order\Decorators\Discount\ValueObjects\Discount;
use app\domain\entities\Order\Decorators\Payment\ValueObject\Payment;
use app\domain\entities\Order\ValueObjects\Buyer;
use app\domain\entities\Order\ValueObjects\Goods;
use app\domain\entities\Order\ValueObjects\Price;

interface BuilderInterface {
	public function addDelivery(Delivery $price): self;

	public function addDiscount(Discount $discount): self;

	public function addPayment(Payment $payment): self;

	public function addPrice(Price $price): self;

	public function addGoods(Goods $goods): self;

	public function addBuyer(Buyer $buyer): self;

	public function reset(): void;

//	public function setMaterials(): void;
}
