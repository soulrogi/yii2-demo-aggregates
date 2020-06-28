<?php

declare(strict_types=1);

namespace app\controllers;

use app\controllers\actions\employeeController\ActionCreate;
use app\controllers\actions\employeeController\ActionIndex;
use yii\web\Controller;

class EmployeeController extends Controller {
	const ACTION_INDEX  = 'index';
	const ACTION_CREATE = 'create';

	public function actions() {
		return [
			static::ACTION_INDEX  => ActionIndex::class,
			static::ACTION_CREATE => ActionCreate::class,
		];
	}
}
