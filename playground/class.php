<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPGen\Builders\ClassBuilder;
use PHPGen\Builders\MethodBuilder;

use function PHPGen\{ buildClass };

echo ClassBuilder::fromObject(new class {
    public function hello() 
    {
        echo 'hello';
    }

    public function great(int $s, bool $isBool): float 
    {
        return $s + $isBool;
    }
})->name('MyClass');

echo "\n\n";

echo ClassBuilder::make('Cat')
    ->final()
    ->methods([
        MethodBuilder::fromClosure('myau', function (): void {
            echo 'myau';
        }),
        MethodBuilder::fromClosure('eatFood', function (float $amount): void {
            // eat some food
        }),
    ]);

echo "\n\n";

echo buildClass('Foo')->readonly()->final();

echo "\n\n";

echo buildClass('Custom')->readonly()->abstract()->extends('CustomAbstract');
