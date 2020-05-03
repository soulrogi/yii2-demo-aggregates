<?php

declare(strict_types=1);

namespace app\domain\entities\Employee\Exceptions;

use app\domain\entities\Employee\ValueObjects\Phone;
use DomainException;

class PhoneAlreadyExistsException extends DomainException {
	public function __construct(Phone $phone) {
		parent::__construct('Phone ' . $phone->getFull() . ' already exists.');
	}
}
