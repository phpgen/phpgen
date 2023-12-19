<?php

require __DIR__ . '/../vendor/autoload.php';

use function PHPGen\buildFunction;
use function PHPGen\buildParameter;

echo buildFunction('sum')
    ->parameters([
        buildParameter('a')->type('int'),
        buildParameter('b')->type('int'),
    ])
    ->return('int')
    ->body('return $a + $b;');

echo PHP_EOL;

echo buildFunction()
    ->fromClosure(function (int|float $number, int|float $sub): int {
        $precision = 2;
        $string    = <<<'HTML'
            <div></div>
        HTML;

        $rounded = (int) round(
            $number - $sub,
            min(
                0,
                $precision
            ),
        );

        return $rounded;
    })
    ->name('subtract');
