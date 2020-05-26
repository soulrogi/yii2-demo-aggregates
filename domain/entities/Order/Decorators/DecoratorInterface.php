<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators;

use app\domain\entities\Order\OrderInterface;

interface DecoratorInterface extends OrderInterface {
	public function getOrder(): OrderInterface;

	public function getInterfacesAddedDecorators(): array;

	public function usedJustOnce(OrderInterface $order, string $interface): void;
}
