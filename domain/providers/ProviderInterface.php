<?php

declare(strict_types=1);

namespace app\domain\providers;

interface ProviderInterface {
	public function getPayload();

	public function getErrors(): array;
}
