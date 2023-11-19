<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPGen\Builders\ClassBuilder;
use PHPGen\Builders\MethodBuilder;

echo ClassBuilder::fromAnonymous('MyClass', new class {
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