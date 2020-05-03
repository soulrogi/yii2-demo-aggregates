<?php

declare(strict_types=1);

namespace app\domain\dispatchers;

interface EventDispatcherInterface {
	public function dispatch(array $events): void ;
}
