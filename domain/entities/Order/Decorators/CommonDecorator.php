<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators;

use app\domain\entities\EventTrait;
use app\domain\entities\Order\Decorators\Exceptions\CanBeUsedJustOnceException;
use app\domain\entities\Order\OrderInterface;
use app\domain\entities\Order\ValueObjects\Buyer;
use app\domain\entities\Order\ValueObjects\Goods;
use app\domain\entities\Order\ValueObjects\Id;
use app\domain\entities\Order\ValueObjects\Price;

abstract class CommonDecorator implements DecoratorInterface {
	use EventTrait;

	/** @var OrderInterface|DecoratorInterface */
	protected OrderInterface $order;

	public function __construct(OrderInterface $order) {
		$this->order = $order;
	}

	public function getOrder(): OrderInterface {
		return $this->order;
	}

	public function getId(): Id {
		return $this->order->getId();
	}

	public function getPrice(): Price {
		return $this->order->getPrice();
	}

	public function getGoods(): Goods {
		return $this->order->getGoods();
	}

	public function getBuyer(): Buyer {
		return $this->order->getBuyer();
	}

	/**
	 * @return string[]
	 */
	public function getInterfacesAddedDecorators(): array {
		$interfaces = ($this->order instanceof DecoratorInterface
			? $this->order->getInterfacesAddedDecorators()
			: []
		);

		return array_merge(class_implements($this), $interfaces);
	}

	/**
	 * @param OrderInterface|DecoratorInterface $order
	 * @param string                            $interface
	 */
	public function usedJustOnce(OrderInterface $order, string $interface): void {
		if (
			$order instanceof DecoratorInterface
			&& array_key_exists($interface, $order->getInterfacesAddedDecorators())
		) {
			throw new CanBeUsedJustOnceException;
		}
	}
}
