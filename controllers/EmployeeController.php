<?php

declare(strict_types=1);

namespace app\controllers;

use app\controllers\actions\EmployeeControllerActionCreate;
use app\controllers\actions\EmployeeControllerActionIndex;
use yii\web\Controller;

class EmployeeController extends Controller {
	const ACTION_INDEX  = 'index';
	const ACTION_CREATE = 'create';

	public function actions() {
		return [
			static::ACTION_INDEX  => EmployeeControllerActionIndex::class,
			static::ACTION_CREATE => EmployeeControllerActionCreate::class,
		];
	}
}
