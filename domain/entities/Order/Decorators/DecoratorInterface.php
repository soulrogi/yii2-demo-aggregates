<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators;

interface DecoratorInterface {
	public function getInterfacesAddedDecorators(): array;
}
