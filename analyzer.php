#!/usr/bin/env php
<?php
require_once 'vendor/autoload.php';

use App\Commands\PrintProducts;
use Symfony\Component\Console\Application;

$app = new Application();

$app->add(new PrintProducts());
$app->run();