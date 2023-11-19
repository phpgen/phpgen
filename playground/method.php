<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPGen\Builders\FunctionParameterBuilder;
use PHPGen\Builders\MethodBuilder;

echo MethodBuilder::make('sum')
    ->private()
    ->parameters([
        FunctionParameterBuilder::make('a')->type('int'),
        FunctionParameterBuilder::make('b')->type('int'),
    ])
    ->return('int')
    ->body('return $a + $b;');
