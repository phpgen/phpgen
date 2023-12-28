<?php

require __DIR__ . '/../vendor/autoload.php';


use function PHPGen\buildInterface;
use function PHPGen\buildMethod;
use function PHPGen\buildParameter;

echo buildInterface()
    ->name('MyInterface')
    ->extends(['Stringable', 'Arrayable'])
    ->addExtend('Jsonable')
    ->methods([
        buildMethod('foo')->return('int')->parameters([
            buildParameter('a')->type('int'),
        ]),
    ]);

echo "\n\n";
