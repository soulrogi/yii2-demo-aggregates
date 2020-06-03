<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Helpers;

use app\domain\entities\Order\Decorators\DecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Delivery\DeliveryDecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Delivery\ValueObjects\Delivery;
use app\domain\entities\Order\Decorators\Implementations\Discount\DiscountDecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Discount\ValueObjects\Discount;
use app\domain\entities\Order\Decorators\Strategies\Unpacker\UnpackerStrategyProvider;
use app\domain\entities\Order\OrderInterface;

class DecoratorHelper {
	/**
	 * @param OrderInterface|DecoratorInterface $order
	 * @param string             $interface
	 *
	 * @return array
	 */
	static public function getPayloadByInterface(OrderInterface $order, string $interface): array {
		if (false === ($order instanceof DecoratorInterface)) {
			return [];
		}

		$result = [];
		if ($order instanceof $interface) {
			$result[] = UnpackerStrategyProvider::getStrategy($interface)->getPayloads($order);
		}

		$subResult = static::getPayloadByInterface($order->getOrder(), $interface);

		return array_merge($result, $subResult);
	}

	static public function getDiscounts(OrderInterface$order):array {
		return array_map(function(Discount $discount): string {
			return $discount->getName();
		}, static::getPayloadByInterface($order, DiscountDecoratorInterface::class));
	}

	/**
	 * @param OrderInterface $order
	 *
	 * @return Delivery[]
	 */
	static public function getDeliveries(OrderInterface$order):array {
		return static::getPayloadByInterface($order, DeliveryDecoratorInterface::class);
	}
}
