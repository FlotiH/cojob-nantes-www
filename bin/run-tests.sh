#!/usr/bin/env bash

symfony console doctrine:database:drop --force --env=test
symfony console doctrine:database:create --env=test
symfony console doctrine:migrations:migrate -n --env=test
symfony console doctrine:fixtures:load -n --env=test
SYMFONY_DEPRECATIONS_HELPER=disabled symfony php vendor/bin/phpunit