<?php

declare(strict_types=1);

namespace app\domain\dispatchers;

use Yii;

class DummyEventDispatcher implements EventDispatcherInterface {
	public function dispatch(array $events): void {
		foreach ($events as $event) {
			Yii::info('Dispatch event ' . get_class($event));
		}
	}
}
