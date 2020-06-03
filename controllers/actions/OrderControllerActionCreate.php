<?php

declare(strict_types=1);

namespace app\controllers\actions;

use app\controllers\OrderController;
use app\domain\entities\Order\Decorators\Helpers\DecoratorHelper;
use app\domain\services\Order\OrderService;
use app\domain\yii2\forms\OrderCreateForm;
use DomainException;
use yii\base\Action;
use yii\web\ErrorHandler;
use yii\web\Response;

class OrderControllerActionCreate extends Action {
	protected OrderCreateForm $form;
	protected ErrorHandler    $errorHandler;
	protected OrderService    $service;

	public function __construct(
		string $id,
		OrderController $controller,
		OrderCreateForm $form,
		OrderService $orderService,
		ErrorHandler $errorHandler,
		array $config = []
	) {
		$this->form         = $form;
		$this->service      = $orderService;
		$this->errorHandler = $errorHandler;

		parent::__construct($id, $controller, $config);
	}

	public function run(): Response {
		try {
			$order      = $this->service->create();
			$items      = $order->getGoods()->remove('e691b6ee-fe47-42d7-81c7-0794593f29f6');
			$discounts  = DecoratorHelper::getDiscounts($order);
			$deliveries = DecoratorHelper::getDeliveries($order);

			return $this->controller->asJson([
				'OrderId'        => $order->getId()->getId(),
				'Removed Item'   => $items->getId(),
				'DiscountsNames' => $discounts,
				'DeliveryId'     => end($deliveries)->getId(),
			]);
		}
		catch (DomainException $e) {
			$this->errorHandler->logException($e);

			return $this->controller->asJson(['data' => $e->getMessage()]);
		}
	}
}
