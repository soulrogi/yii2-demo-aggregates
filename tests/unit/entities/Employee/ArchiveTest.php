<?php

namespace app\tests\unit\entities\Employee;

use app\domain\entities\Employee\Events\EmployeeArchived;
use app\domain\entities\Employee\ValueObjects\Name;
use Codeception\Test\Unit;
use DateTimeImmutable;

class ArchiveTest extends Unit {
	public function testSuccess(): void {
		$employee = (new EmployeeBuilder)->build();
		$employee->rename($name = new Name('New', 'Test', 'Name'));

		$this->assertTrue($employee->isActive());
		$this->assertFalse($employee->isArchived());

		$employee->archive($date = new DateTimeImmutable('2011-06-15'));

		$this->assertFalse($employee->isActive());
		$this->assertTrue($employee->isArchived());

		$this->assertNotEmpty($statuses = $employee->getStatuses());
		$this->assertTrue(end($statuses)->isArchived());

		$this->assertNotEmpty($events = $employee->releaseEvents());
		$this->assertInstanceOf(EmployeeArchived::class, end($events));
	}

	public function testAlreadyArchived(): void {
		$employee = (new EmployeeBuilder)->archived()->build();

		$this->expectExceptionMessage('Employee is already archived.');
		$employee->archive(new DateTimeImmutable);
	}
}
