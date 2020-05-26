<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Helpers;

use app\domain\entities\Order\Decorators\DecoratorInterface;
use app\domain\entities\Order\Decorators\Strategies\Unpacker\UnpackerStrategyProvider;
use app\domain\entities\Order\OrderInterface;

class DecoratorHelper {
	/**
	 * @param OrderInterface|DecoratorInterface $order
	 * @param string             $interface
	 *
	 * @return array
	 */
	public static function getPayloadByInterface(OrderInterface $order, string $interface): array {
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
}
