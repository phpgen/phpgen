<?php

require __DIR__ . '/../vendor/autoload.php';

use function PHPGen\buildMethod;
use function PHPGen\buildParameter;

echo buildMethod('increment')
    ->private()
    ->parameters([
        buildParameter('target')->type(['int', 'float'])->byRef(),
        buildParameter('amount')->type(['int', 'float']),
    ])
    ->returnReferenced(['int', 'float'])
    ->body('return $target = $target + $amount;');
