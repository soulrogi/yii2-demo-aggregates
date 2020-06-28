<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Helpers;

use app\domain\entities\Order\Decorators\DecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Delivery\DeliveryDecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Delivery\ValueObjects\Delivery;
use app\domain\entities\Order\Decorators\Implementations\Discount\DiscountDecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Discount\ValueObjects\Discount;
use app\domain\entities\Order\Decorators\Strategies\Unpacker\UnpackerStrategy;
use app\domain\entities\Order\OrderInterface;

class DecoratorUnpacker {
	protected OrderInterface $order;

	public function __construct(OrderInterface $order) {
		$this->order = $order;
	}

	/**
	 * @param OrderInterface|DecoratorInterface $order
	 * @param string                            $strategyInterface
	 *
	 * @return array
	 */
	public function getPayloadByInterface(OrderInterface $order, string $strategyInterface): array {
		if (false === ($order instanceof DecoratorInterface)) {
			return [];
		}

		$result = [];
		if ($order instanceof $strategyInterface) {
			$result[] = UnpackerStrategy::getStrategy($strategyInterface)->getPayloads($order);
		}

		$subResult = $this->getPayloadByInterface($order->getOrder(), $strategyInterface);

		return array_merge($result, $subResult);
	}

	/**
	 * @return Discount[]
	 */
	public function getDiscounts(): array {
		return array_map(
			fn(Discount $discount): string => ($discount->getName()),
			$this->getPayloadByInterface($this->order, DiscountDecoratorInterface::class)
		);
	}

	/**
	 * @return Delivery[]
	 */
	public function getDeliveries():array {
		return $this->getPayloadByInterface($this->order, DeliveryDecoratorInterface::class);
	}
}
