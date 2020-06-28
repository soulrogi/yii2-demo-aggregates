<?php

declare(strict_types=1);

namespace app\domain\infrastructure\yii2\repositories\Employee;

use app\domain\entities\Employee\Employee;
use app\domain\entities\Employee\ValueObjects\Address;
use app\domain\entities\Employee\ValueObjects\Id;
use app\domain\entities\Employee\ValueObjects\Name;
use app\domain\entities\Employee\ValueObjects\Phone;
use app\domain\entities\Employee\ValueObjects\Phones;
use app\domain\entities\Employee\ValueObjects\Status;
use app\domain\repositories\Employee\Exceptions\EmployeeNotFoundException;
use app\domain\repositories\Employee\Exceptions\PhonesNotFoundException;
use app\domain\repositories\EmployeeRepositoryInterface;
use app\domain\repositories\Hydrator;
use DateTimeImmutable;
use DateTimeInterface;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Proxy\LazyLoadingInterface;
use yii\db\Connection;
use yii\db\Query;
use yii\helpers\Json;

/**
 * В связи с сохранением вложенных объектов часто возникает вопрос,
 * как можно в агрегате отслеживать изменения внутренних элементов и как их при этом сохранять.
 * Например, что делать, если в агрегате появился новый телефон или удалился один из старых?
 * Здесь возможны два варианта:
 *    - Если это полноценные сущности (с идентификатором),
 *      на которые по какой-то причине могут ссылаться внешними ключами записи других таблиц в БД,
 *      то в момент запроса из базы в методе get() можно запомнить копию массива строк в приватном
 *      поле репозитория $this->items[$employeeId]['phones'],
 *      а потом (при сохранении в методе save()) сравнить новые телефоны с массивом старых
 *      функцией array_udiff и добавить/удалить/обновить только отличающиеся.
 *    - Если это просто массив элементов, никому снаружи не нужных,
 *      то можно просто очистить все старые строки телефонов по employee_id и вставить заново.
 */
class SqlEmployeeRepository implements EmployeeRepositoryInterface {
	protected const TABLE_EMPLOYEES         = 'sql_employees';
	protected const TABLE_EMPLOYEE_PHONES   = 'sql_employee_phones';

	protected Connection $db;
	protected Hydrator $hydrator;
	protected LazyLoadingValueHolderFactory $lazyFactory;

	public function __construct(
		Connection $db,
		Hydrator $hydrator,
		LazyLoadingValueHolderFactory $lazyFactory
	) {
		$this->db          = $db;
		$this->hydrator    = $hydrator;
		$this->lazyFactory = $lazyFactory;
	}

	public function get(Id $id): Employee {
		//region -- Get employee from DB
		$employee = (new Query)
			->select('*')
			->from(static::TABLE_EMPLOYEES)
			->andWhere(['id' => $id->getId()])
			->one($this->db)
		;
		if (false === $employee) {
			throw new EmployeeNotFoundException;
		}
		//endregion

		//region -- Lazyload data from DB
		$phones = $this->lazyFactory->createProxy(
			Phones::class,
			function(&$target, LazyLoadingInterface $proxy) use ($id): void {
				$phones = (new Query)
					->select('*')
					->from(static::TABLE_EMPLOYEE_PHONES)
					->andWhere(['employee_id' => $id->getId()])
					->orderBy('id')
					->all($this->db)
				;

				if (false === $phones) {
					throw new PhonesNotFoundException;
				}

				$phonesModels = array_map(function(array $phone): Phone {
					return new Phone(
						(int) $phone['country'],
						$phone['code'],
						$phone['number']
					);
				}, $phones);

				$target = new Phones($phonesModels);

				$proxy->setProxyInitializer(null); // Unset the initializer for the proxy instance
			}
		);
		//endregion

		//region -- Prepare data to insert into Employee
		$statuses = array_map(function(array $status): Status {
			return new Status(
				$status['value'],
				new DateTimeImmutable($status['date'])
			);
		}, Json::decode(Json::decode($employee['statuses']))); // todo разобраться почему так происходит!!!

		$fields = [
			'id'         => new Id($employee['id']),
			'name'       => new Name(
				$employee['name_last'],
				$employee['name_first'],
				$employee['name_middle']
			),
			'address'    => new Address(
				$employee['address_country'],
				$employee['address_region'],
				$employee['address_city'],
				$employee['address_street'],
				$employee['address_house']
			),
			'createDate' => new DateTimeImmutable($employee['create_date']),
			'phones'     => $phones,
			'statuses'   => $statuses,
		];
		//endregion

		/** @var Employee $result */
		$result = $this->hydrator->hydrate(Employee::class, $fields);

		return $result;
	}

	public function add(Employee $employee): void {
		$this->db->transaction(function () use ($employee) {
			$this->db->createCommand()->insert(
				static::TABLE_EMPLOYEES,
				static::extractEmployeeData($employee)
			)->execute();

			$this->updatePhones($employee);
		});
	}

	public function save(Employee $employee): void {
		$this->db->transaction(function() use ($employee) {
			$this->db->createCommand()->update(
				static::TABLE_EMPLOYEES,
				static::extractEmployeeData($employee),
				['id' => $employee->getId()->getId()]
			)->execute();

			$this->updatePhones($employee);
		});
	}

	public function remove(Employee $employee): void {
		$this->db->createCommand()->delete(
			static::TABLE_EMPLOYEES,
			['id' => $employee->getId()->getId()]
		)->execute();
	}

	private function updatePhones(Employee $employee): void {
		/** @var Phones|LazyLoadingInterface $phones */
		$field  = 'phones';
		$phones = $this->hydrator->extract($employee, [$field])[$field];
		if ($phones instanceof LazyLoadingInterface && false === $phones->isProxyInitialized()) {
			return;
		}

		$this->db
			->createCommand()
			->delete(
				static::TABLE_EMPLOYEE_PHONES,
				['employee_id' => $employee->getId()->getId()]
			)
			->execute()
		;

		$this->db
			->createCommand()
			->batchInsert(
				static::TABLE_EMPLOYEE_PHONES,
				['employee_id', 'country', 'code', 'number'],
				array_map(function (Phone $phone) use ($employee): array {
					return [
						'employee_id' => $employee->getId()->getId(),
						'country'     => $phone->getCountry(),
						'code'        => $phone->getCode(),
						'number'      => $phone->getNumber()
					];
				}, $employee->getPhones())
			)
			->execute()
		;
	}

	private static function extractEmployeeData(Employee $employee): array {
		$statuses     = $employee->getStatuses();
		$statusesJson = Json::encode(array_map(function(Status $status): array {
			return [
				'value' => $status->getValue(),
				'date'  => $status->getDate()->format(DATE_ATOM),
			];
		}, $statuses), JSON_FORCE_OBJECT);

		return [
			'id'              => $employee->getId()->getId(),
			'create_date'     => $employee->getCreateDate()->format(DateTimeInterface::ATOM),
			'name_last'       => $employee->getName()->getLast(),
			'name_middle'     => $employee->getName()->getMiddle(),
			'name_first'      => $employee->getName()->getFirst(),
			'address_country' => $employee->getAddress()->getCountry(),
			'address_region'  => $employee->getAddress()->getRegion(),
			'address_city'    => $employee->getAddress()->getCity(),
			'address_street'  => $employee->getAddress()->getStreet(),
			'address_house'   => $employee->getAddress()->getHouse(),
			'current_status'  => end($statuses)->getValue(),
			'statuses'        => $statusesJson,
		];
	}
}
