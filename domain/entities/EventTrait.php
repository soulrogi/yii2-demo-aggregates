<?php

declare(strict_types=1);

namespace app\domain\entities;

trait EventTrait {
	/** @var Event[] */
	private array $events = [];

	public function releaseEvents(): array {
		$events       = $this->events;
		$this->events = [];

		return $events;
	}

	protected function recordEvent(Event $event): void {
		$this->events[] = $event;
	}
}
