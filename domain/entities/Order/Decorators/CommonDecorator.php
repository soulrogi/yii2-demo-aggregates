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

/**
 * Базовый класс Декоратора следует тому же интерфейсу, что и другие компоненты.
 * Основная цель этого класса - определить интерфейс обёртки для всех конкретных
 * декораторов. Реализация кода обёртки по умолчанию может включать в себя поле
 * для хранения завёрнутого компонента и средства его инициализации.
 */
abstract class CommonDecorator implements OrderInterface, DecoratorInterface {
	use EventTrait;

	/** @var OrderInterface|CommonDecorator */
	protected OrderInterface $order;

	public function __construct(OrderInterface $order) {
		$this->order = $order;
	}

	/**
	 * @return CommonDecorator|OrderInterface
	 */
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
	 * @param OrderInterface|CommonDecorator $order
	 *
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
	 * @param    OrderInterface|CommonDecorator $order
	 * @param    string                         $interface
	 */
	public function usedJustOnce(OrderInterface $order, string $interface): void {
		if (
			[] !== class_parents($order)
			&& array_key_exists($interface, $order->getInterfacesAddedDecorators())
		) {
			throw new CanBeUsedJustOnceException;
		}
	}
}
