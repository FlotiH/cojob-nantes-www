#!/usr/bin/env bash

symfony console doctrine:database:drop --force --env=test
symfony console doctrine:database:create --env=test
symfony console doctrine:migrations:migrate -n --env=test
symfony console doctrine:fixtures:load -n --env=test
XDEBUG_MODE=coverage SYMFONY_DEPRECATIONS_HELPER=disabled symfony php vendor/bin/phpunit --coverage-html public/test-coverage
#without generating code coverage info
#SYMFONY_DEPRECATIONS_HELPER=disabled symfony php vendor/bin/phpunit