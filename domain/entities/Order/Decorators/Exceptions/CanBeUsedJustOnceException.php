<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Decorators\Exceptions;

use DomainException;

class CanBeUsedJustOnceException extends DomainException {
	public function __construct() {
		parent::__construct('Decorator can be used just once');
	}
}
