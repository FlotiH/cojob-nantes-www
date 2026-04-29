# cojob-nantes-www

Website for Cojob Nantes association

### Run composer

```bash
symfony composer install
```

### For local use:

```bash
symfony server:start --port=8007
```

### Doctrine migration

```bash
symfony console do:mi:mi
```

### Assets

```bash
symfony console asset-map:compile
``

ou

```bash
php bin/console asset-map:compile
``

### Run Php cs fixer

/!\ Please run php cs fixer before each commit (manually or in a pre-commit hook for instance) and check what is updated:

```bash
./vendor/bin/php-cs-fixer fix --allow-risky=yes
```

### Run tests

/!\ Please run tests before each commit (manually or in a pre-commit hook for instance):

This command delete and create a new database suffixed by test, run migrations, fixtures and tests

```bash
bash bin/run-tests.sh 
```

To run only one test without fixtures loading:

```bash
symfony php vendor/bin/phpunit
```

or without deprecations helper :

```bash
SYMFONY_DEPRECATIONS_HELPER=disabled symfony php vendor/bin/phpunit
```

### Google credentials

Add credentials.json file in assets directory

### Generate images

```bash
vendor/bin/image-optimizer
```
