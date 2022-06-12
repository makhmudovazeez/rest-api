command_rates:
	php bin/console get:rates

migration:
	php bin/console make:migration

migrate:
	php bin/console doctrine:migrations:migrate

db_drop:
	php bin/console doctrine:database:drop --force

db_create:
	php bin/console doctrine:database:create

command:
	php bin/console make:command

entity:
	php bin/console make:entity

controller:
	php bin/console make:controller

fixtures:
	php bin/console make:fixtures

fixtures_load:
	php bin/console doctrine:fixtures:load

