<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPGen\Builders\FunctionBuilder;
use PHPGen\Builders\FunctionParameterBuilder;
use PHPGen\Builders\TypeBuilder;

echo FunctionBuilder::make('sum')
    ->parameters([
        FunctionParameterBuilder::make('a')->type('int'),
        FunctionParameterBuilder::make('b')->type('int'),
    ])
    ->return('int')
    ->body('return $a + $b;');

echo "\n\n";

echo TypeBuilder::make(['int', ['Stringable', 'Arrayable']]);

echo "\n\n";

echo TypeBuilder::make('int');
