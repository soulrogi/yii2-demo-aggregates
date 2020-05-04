<?php

declare(strict_types=1);

namespace app\tests\_fixtures;

use yii\test\ActiveFixture;

class EmployeeStatusFixture extends ActiveFixture {
	public $tableName = 'sql_employee_statuses';
	public $dataFile = '@app/tests/_fixtures/data/employees_status.php';
}
