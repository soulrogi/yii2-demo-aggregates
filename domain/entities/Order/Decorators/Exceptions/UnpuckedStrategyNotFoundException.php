<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Exceptions;

use DomainException;

class UnpuckedStrategyNotFoundException extends DomainException {
	public function __construct() {
		parent::__construct('Strategy not found.');
	}
}
