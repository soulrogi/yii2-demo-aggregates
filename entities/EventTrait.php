<?php

namespace app\entities;

use app\entities\Employee\Events\Event;

trait EventTrait {
	/** @var Event[] */
	private $events;

	public function releaseEvents(): array {
		$events       = $this->events;
		$this->events = [];

		return $events;
	}

	protected function recordEvent(Event $event): void {
		$this->events[] = $event;
	}
}
