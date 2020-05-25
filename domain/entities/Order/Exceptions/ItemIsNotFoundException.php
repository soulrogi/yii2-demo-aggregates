<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Exceptions;

use DomainException;

class ItemIsNotFoundException extends DomainException {
	public function __construct() {
		parent::__construct('Items is not found.');
	}
}
