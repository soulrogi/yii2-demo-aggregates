<?php

namespace app\tests\unit\entities\Employee;

use app\domain\entities\Employee\Events\EmployeeRemoved;
use app\domain\entities\Employee\Exceptions\RemoveActiveEmployeeException;
use Codeception\Test\Unit;

class RemoveTest extends Unit {
	public function testSuccess(): void {
		$employee = (new EmployeeBuilder)->archived()->build();

		$employee->remove();

		$this->assertNotEmpty($events = $employee->releaseEvents());
		$this->assertInstanceOf(EmployeeRemoved::class, end($events));
	}

	public function testNotArchived(): void {
		$employee = (new EmployeeBuilder)->build();

		$this->expectException(RemoveActiveEmployeeException::class);
		$employee->remove();
	}
}
