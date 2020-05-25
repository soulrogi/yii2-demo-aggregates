<?php

declare(strict_types=1);

namespace app\controllers;

use app\controllers\actions\OrderControllerActionCreate;
use yii\web\Controller;

class OrderController extends Controller {
	const ACTION_CREATE = 'create';

	public function actions() {
		return [static::ACTION_CREATE => OrderControllerActionCreate::class];
	}
}
