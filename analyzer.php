#!/usr/bin/env php
<?php
require_once 'vendor/autoload.php';

use App\Commands\Run;
use Symfony\Component\Console\Application;

$app = new Application();

$app->add(new Run());
$app->run();