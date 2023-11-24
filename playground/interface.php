<?php

require __DIR__ . '/../vendor/autoload.php';


use function PHPGen\{ buildInterface };

echo buildInterface()
    ->name('MyInterface')
    ->extends(['\Stringabl  e'])
    ->addExtends(['\Array  able ///\\'])
    ->addExtends('Jsonable');

echo "\n\n";
