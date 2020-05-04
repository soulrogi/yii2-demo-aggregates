<?php

declare(strict_types=1);

namespace app\domain\dispatchers;

/**
 * @see \Psr\EventDispatcher\EventDispatcherInterface
 */
interface EventDispatcherInterface {
	public function dispatch(array $events): void ;
}
