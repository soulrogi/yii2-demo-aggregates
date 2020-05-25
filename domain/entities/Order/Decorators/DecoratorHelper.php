<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators;

use app\domain\entities\Order\Decorators\Delivery\DeliveryDecoratorInterface;
use app\domain\entities\Order\Decorators\Delivery\DeliveryUnpackerStrategy;
use app\domain\entities\Order\Decorators\Discount\DiscountDecoratorInterface;
use app\domain\entities\Order\Decorators\Discount\DiscountUnpackerStrategy;
use app\domain\entities\Order\Decorators\Payment\PaymentDecoratorInterface;
use app\domain\entities\Order\Decorators\Payment\PaymentUnpackerStrategy;
use app\domain\entities\Order\OrderInterface;

class DecoratorHelper {
	protected const DECORATORS_UNPACKERS_STRATEGY = [
		PaymentDecoratorInterface::class  => PaymentUnpackerStrategy::class,
		DeliveryDecoratorInterface::class => DeliveryUnpackerStrategy::class,
		DiscountDecoratorInterface::class => DiscountUnpackerStrategy::class,
	];

	/**
	 * @param OrderInterface|CommonDecorator $order
	 * @param string                         $interface
	 *
	 * @return array
	 */
	public static function getPayloadByInterface(OrderInterface $order, string $interface): array {
		if (false === ($order instanceof DecoratorInterface)) {
			return [];
		}

		$result = [];
		if ($order instanceof $interface) {
			$strategyName = static::DECORATORS_UNPACKERS_STRATEGY[$interface];
			/** @var DecoratorUnpackerStrategyInterface $strategy */
			$strategy = new $strategyName;
			$result[] = $strategy->getPayloads($order);
		}

		return array_merge($result, static::getPayloadByInterface($order->getOrder(), $interface));
	}
}
