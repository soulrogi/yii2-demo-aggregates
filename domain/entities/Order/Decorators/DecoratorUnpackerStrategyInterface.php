<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators;

use app\domain\entities\Order\OrderInterface;

interface DecoratorUnpackerStrategyInterface {
	public static function getPayloads(OrderInterface $order);
}
