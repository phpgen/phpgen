<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPGen\Builders\FunctionBuilder;
use PHPGen\Builders\FunctionParameterBuilder;
use PHPGen\Builders\MethodBuilder;


echo FunctionBuilder::make('sum')
    ->parameters([
        FunctionParameterBuilder::make('a')->type('int'),
        FunctionParameterBuilder::make('b')->type('int'),
    ])
    ->return('int')
    ->body('return $a + $b;');

echo "\n";

echo MethodBuilder::make('sum')
    ->private()
    ->parameters([
        FunctionParameterBuilder::make('a')->type('int'),
        FunctionParameterBuilder::make('b')->type('int'),
    ])
    ->return('int')
    ->body('return $a + $b;');

echo "\n";

echo MethodBuilder::fromClosure('sum', function (int $a, int $b): int { return $a + $b; });