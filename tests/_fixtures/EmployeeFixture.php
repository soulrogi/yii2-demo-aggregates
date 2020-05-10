<?php

declare(strict_types=1);

namespace app\tests\_fixtures;

use yii\test\ActiveFixture;

class EmployeeFixture extends ActiveFixture {
	const NAME = 'employee';

	public $tableName = 'sql_employees';
	public $dataFile = '@app/tests/_fixtures/data/employees.php';
}
