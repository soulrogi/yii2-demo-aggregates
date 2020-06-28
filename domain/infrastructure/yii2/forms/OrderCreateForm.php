<?php

declare(strict_types=1);

namespace app\domain\infrastructure\yii2\forms;

use app\domain\services\Order\OrderCreation\dto\OrderCreationDto;
use Ramsey\Uuid\Uuid;
use yii\base\Model;

class OrderCreateForm extends Model {
	public function getDto(): OrderCreationDto {
		$dto           = new OrderCreationDto;
		$dto->basketId = Uuid::uuid4()->toString();

		return $dto;
	}
}
