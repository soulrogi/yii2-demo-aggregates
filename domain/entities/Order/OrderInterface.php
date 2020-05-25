<?php

declare(strict_types=1);

namespace app\domain\entities\Order;

use app\domain\entities\AggregateRoot;
use app\domain\entities\Order\ValueObjects\Buyer;
use app\domain\entities\Order\ValueObjects\Goods;
use app\domain\entities\Order\ValueObjects\Id;
use app\domain\entities\Order\ValueObjects\Price;


/**
 * Базовый интерфейс Компонента определяет поведение, которое изменяется декораторами.
 */
interface OrderInterface extends AggregateRoot {
	public function getId(): Id;

	public function getPrice(): Price;

	public function getGoods(): Goods;

	public function getBuyer(): Buyer;
}
