<?php

namespace app\tests\unit\entities\Employee;

use app\domain\entities\Employee\Events\EmployeeReinstated;
use app\domain\entities\Employee\Exceptions\RemoveActiveEmployeeException;
use Codeception\Test\Unit;
use DateTimeImmutable;

class ReinstateTest extends Unit {
	public function testSuccess(): void {
		$employee = (new EmployeeBuilder)->archived()->build();

		$this->assertFalse($employee->isActive());
		$this->assertTrue($employee->isArchived());

		$employee->reinstate($date = new DateTimeImmutable('2011-06-15'));

		$this->assertTrue($employee->isActive());
		$this->assertFalse($employee->isArchived());

		$this->assertNotEmpty($statuses = $employee->getStatuses());
		$this->assertTrue(end($statuses)->isActive());

		$this->assertNotEmpty($events = $employee->releaseEvents());
		$this->assertInstanceOf(EmployeeReinstated::class, end($events));
	}

	public function testNotArchived(): void {
		$employee = (new EmployeeBuilder)->build();

		$this->expectException(RemoveActiveEmployeeException::class);
		$employee->remove();
	}
}
