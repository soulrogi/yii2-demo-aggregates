<?php

namespace app\domain\entities;

interface AggregateRoot {
	public function releaseEvents(): array;
}
