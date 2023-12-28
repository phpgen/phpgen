<?php

use PHPGen\Builders\FunctionBodyBuilder;
use PHPGen\Parsers\FunctionBodyParser;

require __DIR__ . '/../vendor/autoload.php';

use function PHPGen\buildMethod;
use function PHPGen\buildParameter;

// echo buildMethod()
//     ->fromClosure(function &(int|float &$target, int|float $amount): int|float {
//         return $target = $target + $amount;
//     })
//     ->name('increment')
//     ->private();
// ->parameters([
//     buildParameter('target')->type(['int', 'float'])->byRef(),
//     buildParameter('amount')->type(['int', 'float']),
// ])
// ->returnReferenced(['int', 'float'])
// ->body('return $target = $target + $amount;');

$fn1 = function &(int|float &$target, int|float $amount): int|float {
    return $target = $target + $amount;
};

$fn2 = function &(int|float &$target, int|string $amount = '{'): int|float {
    $int = 12;
    $str = "{$int}";
    // {{ wow
    /**
     * {{ how
     */
    somefunction(function () {

    });

    return $str;
};
function () {
};


$r1 = new ReflectionFunction($fn1);
$r2 = new ReflectionFunction($fn2);
$r3 = (new ReflectionClass(FunctionBodyParser::class))->getMethod('parse');

FunctionBodyBuilder::fromReflection($r1);
echo PHP_EOL;
FunctionBodyBuilder::fromReflection($r2);
echo PHP_EOL;
FunctionBodyBuilder::fromReflection($r3);
echo PHP_EOL;

// FunctionBodyBuilder::fromReflection($r2);
