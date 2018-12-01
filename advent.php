#!/usr/bin/php
<?php

require_once __DIR__ . '/vendor/autoload.php';

if ($argc < 2) {
    echo 'Usage: ./advent <day> [input arguments]';

    exit(1);
}

array_shift($argv);

$day = array_shift($argv);
$input = $argv;

$problem = \Advent\Solver\SolverFactory::create($day);
echo $problem->solve($input) . PHP_EOL;
