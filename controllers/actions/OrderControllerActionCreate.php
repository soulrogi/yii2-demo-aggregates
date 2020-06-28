<?php

declare(strict_types=1);

namespace app\controllers\actions;

use app\controllers\OrderController;
use app\domain\infrastructure\yii2\forms\OrderCreateForm;
use app\domain\infrastructure\yii2\helper\ResponseDto;
use app\domain\providers\Order\OrderProvider;
use app\domain\providers\ProviderInterface;
use app\domain\services\Order\OrderCreation\OrderCreationService;
use Yii;
use yii\base\Action;
use yii\web\Response;

class OrderControllerActionCreate extends Action {
	protected OrderCreateForm         $form;
	protected OrderCreationService    $service;
	protected ProviderInterface       $provider;
	protected ResponseDto             $response;

	public function __construct(
		string $id,
		OrderController $controller,
		OrderCreateForm $form,
		OrderProvider $provider,
		ResponseDto $response,
		array $config = []
	) {
		$this->form     = $form;
		$this->provider = $provider;
		$this->response = $response;

		parent::__construct($id, $controller, $config);
	}

	public function run(): Response {
		if (false === $this->form->load(Yii::$app->request->post(), '')
			&& false === $this->form->validate()
		) {
			$this->response->errors = $this->form->errors;

			return $this->controller->asJson($this->response);
		}

		$this->response->result  = $this->provider->creat($this->form->getDto());
		$this->response->errors  = $this->provider->getErrors();
		$this->response->payload = $this->provider->getPayload();

		return $this->controller->asJson($this->response);
	}
}
