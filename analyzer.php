#!/usr/bin/env php
<?php
require_once 'vendor/autoload.php';

use App\ConsoleCommands\PrintProducts;
use Symfony\Component\Console\Application;

$app = new Application();

$app->add(new PrintProducts());
try {
    $app->run();
} catch (Exception $e) {
}