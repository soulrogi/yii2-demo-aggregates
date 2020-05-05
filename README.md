# Yii 2 DDD Aggregates Demo
Demonstration of domain entities and repositories.

## INSTALLATION

```bash
git clone git@github.com:soulrogi/yii2-demo-aggregates ddd
cd ddd
docker-compose up -d
docker-compose exec php sh
composer insatll
```

## CONFIGURATION
Create databases `db_name` and `db_name_tests`.

Apply migrations:

```bash
./yii migrate
./tests/bin/yii migrate
```

## TESTING
```bash
vendor/bin/codecept run unit entities
vendor/bin/codecept run unit repositories
```
