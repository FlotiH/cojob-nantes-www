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

### Run tests

/!\ Please run tests before each commit (manually or in a pre-commit hook for instance) :

```bash
symfony php bin/phpunit
```

or without deprecations helper :

```bash
SYMFONY_DEPRECATIONS_HELPER=disabled symfony php bin/phpunit
```

### Google credentials

Add credentials.json file in assets directory