<?php

declare(strict_types=1);

namespace app\domain\repositories;

use app\domain\entities\Order\Order;
use app\domain\entities\Order\ValueObjects\Buyer;
use app\domain\entities\Order\ValueObjects\Id;

interface OrderRepositoryInterface {
	public function getById(Id $id): Order;

	public function getByBuyer(Buyer $buyer): array;

	public function add(Order $order): void;

	public function save(Order $order): void;

	public function remove(Order $order): void;
}
