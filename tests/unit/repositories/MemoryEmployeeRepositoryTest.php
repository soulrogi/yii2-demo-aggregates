<?php

declare(strict_types=1);

namespace app\tests\unit\repositories;

use app\domain\repositories\Employee\MemoryEmployeeRepository;

class MemoryEmployeeRepositoryTest extends BaseRepositoryTest {
	protected function _before() {
		$this->repository = new MemoryEmployeeRepository;
	}
}
