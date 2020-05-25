<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Builder;

use app\domain\entities\Order\Decorators\Delivery\DeliveryDecorator;
use app\domain\entities\Order\Decorators\Delivery\ValueObjects\Delivery;
use app\domain\entities\Order\Decorators\Discount\DiscountDecorator;
use app\domain\entities\Order\Decorators\Discount\ValueObjects\Discount;
use app\domain\entities\Order\Decorators\Payment\PaymentDecorator;
use app\domain\entities\Order\Decorators\Payment\ValueObject\Payment;
use app\domain\entities\Order\Order;
use app\domain\entities\Order\OrderInterface;
use app\domain\entities\Order\ValueObjects\Buyer;
use app\domain\entities\Order\ValueObjects\Goods;
use app\domain\entities\Order\ValueObjects\Id;
use app\domain\entities\Order\ValueObjects\Price;

class Builder implements BuilderInterface {
	/** @var Discount[] */
	private array     $discounts = [];
	private ?Delivery $delivery;
	private ?Payment  $payment;
	private ?Price    $price;
	private ?Buyer    $buyer;
	private ?Goods    $goods;

	public function addDelivery(Delivery $delivery): self {
		$this->delivery = $delivery;

		return $this;
	}

	public function addDiscount(Discount $discount): self {
		$this->discounts[] = $discount;

		return $this;
	}

	public function addPayment(Payment $payment): self {
		$this->payment = $payment;

		return $this;
	}

	public function addPrice(Price $price): self {
		$this->price = $price;

		return $this;
	}

	public function addGoods(Goods $goods): self {
		$this->goods = $goods;

		return $this;
	}

	public function addBuyer(Buyer $buyer): self {
		$this->buyer = $buyer;

		return $this;
	}

	public function reset(): void {
		$this->discounts = [];
		$this->delivery  = null;
		$this->payment   = null;
		$this->price     = null;
		$this->goods     = null;
		$this->buyer     = null;
	}

	public function getOrder(): OrderInterface {
		$order = new Order(Id::next(), $this->price, $this->goods, $this->buyer);

		$this->setDiscounts($order);
		$this->setPayment($order);
		$this->setDelivery($order);

		$this->reset();

		return $order;
	}

	private function setDiscounts(OrderInterface &$order): void {
		foreach ($this->discounts as $discount) {
			$order = new DiscountDecorator($order, $discount);
		}
	}

	private function setDelivery(OrderInterface &$order): void {
		$order = new DeliveryDecorator($order);
		$order->setDelivery($this->delivery);
	}

	private function setPayment(OrderInterface &$order): void {
		$order = new PaymentDecorator($order);
		$order->setPayment($this->payment);
	}
}
