<?php

namespace Inch9inch;

require __DIR__ . '/../vendor/autoload.php';


use function PHPGen\buildClass;
use function PHPGen\buildFunction;
use function PHPGen\buildMethod;
use function PHPGen\buildParameter;
use function PHPGen\buildProperty;

echo buildClass()->fromObject(new class
{
    public int $may = 1;

    // public function hello0(int $s, bool $isBool)
    // {

    // }

    // public function hello11()
    // {


    //     $a = 1;
    //     $b = "{{{$a}}-1";

    //     $c = function (int $fp): void {
    //         $v = function (): void {
    //         };
    //     };

    //     echo 'hello';
    // }

    public function hello12(\PHPGen\Builders\FunctionBodyBuilder $s, bool $isBool): float
    {
        return $s + $isBool;
    }

});

echo "\n\n";

echo buildClass()->fromNamespaceAndName('App\\Models', 'App\\Models\\2Foo')
    ->final()
    ->properties([
        buildProperty('color')->public()->defaultValue("'red'"),
        buildProperty('_color')->private(),
    ])
    ->methods([
        buildMethod()
            ->parameters([
                buildParameter('str')->type('string'),
                buildParameter('str1')->type('string')->defaultValue('12'),
            ])
            ->body("\$a = \"foo\\nbar\" . \$str;\nreturn \$a;")
            ->return('string'),

        buildFunction()->fromClosure(function &(int $a, array $b): string {
            $v = implode('-', $b);

            return "{$a}  === {$v}";
        }),

        // buildMethod(function (float $amount): void {
        //     // eat some food
        // })->name('eat'),
    ]);

// echo "\n\n";

// echo buildClass('Foo')->readonly()->final();

// echo "\n\n";

// echo buildClass()->readonly()->abstract()->extends('\\CustomAbstrac  t')->implements(['Stringable', 'Arrayable']);
