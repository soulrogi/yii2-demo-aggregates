<?php

declare(strict_types=1);

namespace app\controllers\actions\employeeController;

use app\controllers\EmployeeController;
use app\domain\services\Employee\EmployeeService;
use app\forms\EmployeeCreateForm;
use DomainException;
use Yii;
use yii\base\Action;
use yii\web\Response;

class ActionCreate extends Action {
	protected EmployeeService $service;
	protected EmployeeCreateForm $form;

	public function __construct(
		string $id,
		EmployeeController $controller,
		EmployeeCreateForm $form,
		EmployeeService $service,
		array $config = []
	) {
		$this->service = $service;
		$this->form    = $form;

		parent::__construct($id, $controller, $config);
	}

	public function run(): Response {
		if (false === $this->form->load(Yii::$app->request->post(), '') && false === $this->form->validate()) {
			return $this->controller->asJson(['data' => $this->id]);
		}

		try {
			$this->service->create($this->form->getDto());

			return $this->controller->redirect([EmployeeController::ACTION_INDEX]);
		}
		catch (DomainException $e) {
			Yii::$app->errorHandler->logException($e);

			return $this->controller->asJson(['data' => 'error' ]);
		}
	}
}
