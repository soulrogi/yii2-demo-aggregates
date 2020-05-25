<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Events;

use app\domain\entities\Event;
use app\domain\entities\Order\ValueObjects\Id;

class OrderCreated implements Event {
	public Id $id;

	public function __construct(Id $id) {
		$this->id = $id;
	}
}
