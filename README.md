# cojob-nantes-www

Website for Cojob Nantes association

### Run composer

```bash
symfony composer install
```

### Run yarn

```bash
yarn install
```
```bash
yarn build
```

Or on dev
```bash
yarn encore dev
```

### For local use:

```bash
symfony server:start --port=8007
```

### Doctrine migration

```bash
symfony console do:mi:mi
```

### Run tests

/!\ Please run tests before each commit (manually or in a pre-commit hook for instance) :

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