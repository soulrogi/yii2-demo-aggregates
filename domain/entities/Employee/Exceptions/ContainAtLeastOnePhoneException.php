<?php

declare(strict_types=1);

namespace app\domain\entities\Employee\Exceptions;

use DomainException;

class ContainAtLeastOnePhoneException extends DomainException {
	public function __construct() {
		parent::__construct('Employee must contain at least one phone.');
	}
}
