<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPGen\Builders\ClassBuilder;


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