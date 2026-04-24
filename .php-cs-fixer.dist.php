<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->notPath([
        'config/bundles.php',
        'config/reference.php',
    ])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@autoPHPMigration' => true,
        '@autoPHPMigration:risky' => true,
        '@autoPHPUnitMigration:risky' => true,
        'mb_str_functions' => true,
        'no_unreachable_default_argument_value' => true,
        'php_unit_strict' => true,
        'strict_comparison' => true,
        'strict_param' => true,
    ])
    ->setFinder($finder)
;
