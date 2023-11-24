<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPGen\Builders\ClassBuilder;

use function PHPGen\buildClass;
use function PHPGen\buildMethod;
use function PHPGen\buildParameter;
use function PHPGen\buildProperty;

echo ClassBuilder::fromObject(new class
{
    public $may = 1;

    public function hello()
    {
        echo 'hello';
    }

    public function great(int $s, bool $isBool): float
    {
        return $s + $isBool;
    }
});

echo "\n\n";

echo buildClass('Cat')
    ->final()
    ->properties([
        buildProperty('color')->public(),
        buildProperty('_color')->private(),
    ])
    ->methods([
        buildMethod()
            ->parameters([
                buildParameter('str')->type('string'),
            ])
            ->body("\$a = 'foo' . \$str;\nreturn \$a;")
            ->return('string'),

        buildMethod()->body('echo \'myau\';'),

        buildMethod(function (float $amount): void {
        })->name('eat')->body('// eat some food'),
    ]);

echo "\n\n";

echo buildClass('Foo')->readonly()->final();

echo "\n\n";

echo buildClass()->readonly()->abstract()->extends('\\CustomAbstrac  t')->implements(['Stringable', 'Arrayable']);
