<?php

declare(strict_types=1);

use App\Kernel;
use Doctrine\Persistence\AbstractManagerRegistry;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

new Dotenv()->bootEnv(__DIR__.'/../.env');

/** @var array{'APP_ENV': string, 'APP_DEBUG': string} $_SERVER */
$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();

/** @var AbstractManagerRegistry $doctrine */
$doctrine = $kernel->getContainer()->get('doctrine');

return $doctrine->getManager();
