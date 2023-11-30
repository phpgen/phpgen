<?php

use PHPGen\Builders\TypeBuilder;
use PHPGen\Sanitizers\TypeSanitizer;

require __DIR__ . '/../vendor/autoload.php';


use function PHPGen\buildType;

// echo buildType('foo');

// echo "\n\n";


// echo buildType(['foo']);

// echo "\n\n";


// echo buildType([['foo']]);

// echo "\n\n";


// echo buildType([['\Stringable', '\ReflectionType'], ['\ArrayAccess', '\ReflectionMethod']]);

// echo "\n\n";

// echo PHP_EOL;

// echo buildType('(\ReflectionMethod&\Stringable)|null'), PHP_EOL, PHP_EOL;

// echo buildType('?\ReflectionMethod'), PHP_EOL, PHP_EOL;

// echo buildType(['string', 'int&string']), PHP_EOL, PHP_EOL;

// echo TypeBuilder::fromString('int $var) {}; function validate2 (int'), PHP_EOL, PHP_EOL;

// $tokens = PhpToken::tokenize('<?php function validate (string &$var) {}');

// foreach ($tokens as $token) {
//     echo "Line {$token->line}: {$token->getTokenName()} ('{$token->text}')", PHP_EOL;
// }

// function a((\ReflectionMethod&\Stringable) | (string&array) $a)
// {
//     if ($a instanceof \Stringable) {

//     }
// }

// $array = ['A', 'B', ['C', 'D'], 'E', ['F']];
// var_dump($array);
// echo PHP_EOL, PHP_EOL;
// TypeSanitizer::sanitize($array);
// var_dump($array);
