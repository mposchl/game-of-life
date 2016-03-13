<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console;
use \App\Command\GameCommand;

$app = new Console\Application('game of life');

$app->add(new GameCommand);
$app->run();