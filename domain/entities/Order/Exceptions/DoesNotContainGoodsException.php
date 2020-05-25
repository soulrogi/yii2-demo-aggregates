<?php

declare(strict_types=1);

namespace app\domain\entities\Order\Exceptions;

use DomainException;

class DoesNotContainGoodsException extends DomainException {
	public function __construct() {
		parent::__construct('Does not contain goods.');
	}
}
