<?php

declare(strict_types=1);

namespace app\controllers\actions\employeeController;

use yii\base\Action;
use yii\web\Response;

class ActionIndex extends Action {
	public function run(): Response {
		return $this->controller->asJson(['data' => 'Index action']);
	}
}
