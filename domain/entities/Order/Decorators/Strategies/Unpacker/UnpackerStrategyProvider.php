<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Strategies\Unpacker;

use app\domain\entities\Order\Decorators\Implementations\Delivery\DeliveryDecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Delivery\DeliveryUnpackerStrategy;
use app\domain\entities\Order\Decorators\Implementations\Discount\DiscountDecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Discount\DiscountUnpackerStrategy;
use app\domain\entities\Order\Decorators\Implementations\Payment\PaymentDecoratorInterface;
use app\domain\entities\Order\Decorators\Implementations\Payment\PaymentUnpackerStrategy;
use app\domain\entities\Order\Decorators\Exceptions\UnpuckedStrategyNotFoundException;

class UnpackerStrategyProvider {
	protected const STRATEGIES = [
		PaymentDecoratorInterface::class  => PaymentUnpackerStrategy::class,
		DeliveryDecoratorInterface::class => DeliveryUnpackerStrategy::class,
		DiscountDecoratorInterface::class => DiscountUnpackerStrategy::class,
	];

	public static function getStrategy(string $strategy): DecoratorUnpackerStrategyInterface {
		if (false === isset(static::STRATEGIES[$strategy])) {
			throw new UnpuckedStrategyNotFoundException;
		}

		$instance = static::STRATEGIES[$strategy];

		return new $instance;
	}
}
