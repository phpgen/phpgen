<?php

use PHPGen\Exceptions\ValidationException;

use function PHPGen\buildFunction;
use function PHPGen\buildType;

describe('TypeBuilder', function () {
    test('Make from empty string fails', function () {
        buildType('');
    })->throws(ValidationException::class);

    test('Make from invalid array fails', function () {
        buildType(['string&\ArrayAccess']);
    })->throws(ValidationException::class);

    test('Make from invalid array of arrays fails', function () {
        buildType([['string&\ArrayAccess']]);
    })->throws(ValidationException::class);



    test('Make from empty', function () {
        expect((string) buildType())->toBe('');
        expect((string) buildType(null))->toBe('');
    });

    test('Make from string', function () {
        expect((string) buildType('string'))->toBe('string');
        expect((string) buildType('A'))->toBe('A');
        expect((string) buildType('\B'))->toBe('\B');

        expect((string) buildType('A|B'))->toBe('A|B');
        expect((string) buildType('A | B'))->toBe('A|B');

        expect((string) buildType('A|B|C'))->toBe('A|B|C');
        expect((string) buildType('A | B | C'))->toBe('A|B|C');

        expect((string) buildType('A&B'))->toBe('A&B');
        expect((string) buildType('A & B'))->toBe('A&B');

        expect((string) buildType('A&B&C'))->toBe('A&B&C');
        expect((string) buildType('A & B & C'))->toBe('A&B&C');

        expect((string) buildType('(A&B)|(C&D)'))->toBe('(A&B)|(C&D)');
        expect((string) buildType('(A & B) | (C & D)'))->toBe('(A&B)|(C&D)');

        expect((string) buildType('(A&B&C)|(D&E&F)'))->toBe('(A&B&C)|(D&E&F)');
        expect((string) buildType('(A & B & C) | (D & E & F)'))->toBe('(A&B&C)|(D&E&F)');

        expect((string) buildType('(A&C)|(A&D)|(B&C)|(B&D)'))->toBe('(A&C)|(A&D)|(B&C)|(B&D)');
        expect((string) buildType('(A & C) | (A & D) | (B & C) | (B & D)'))->toBe('(A&C)|(A&D)|(B&C)|(B&D)');
    });

    test('Make from array', function () {
        expect((string) buildType([]))->toBe('');

        expect((string) buildType(['int']))->toBe('int');
        expect((string) buildType(['int', 'string']))->toBe('int|string');

        expect((string) buildType(['A', 'B', 'C', 'D']))->toBe('A|B|C|D');
    });

    test('Make from array of arrays', function () {
        expect((string) buildType([[]]))->toBe('');

        expect((string) buildType([['int']]))->toBe('int');
        expect((string) buildType([['int'], ['string']]))->toBe('int|string');

        expect((string) buildType(['A', ['B']]))->toBe('A|B');
        expect((string) buildType([['A'], 'B']))->toBe('A|B');
        expect((string) buildType([['A'], ['B']]))->toBe('A|B');
        expect((string) buildType([['A'], 'B', ['C'], 'D', ['E']]))->toBe('A|B|C|D|E');

        expect((string) buildType([['A', 'B'], ['C']]))->toBe('(A&B)|C');
        expect((string) buildType([['A', 'B'], 'C']))->toBe('(A&B)|C');

        expect((string) buildType([['A', 'B'], []]))->toBe('A&B');
        expect((string) buildType([['A', 'B'], ['']]))->toBe('A&B');
        expect((string) buildType([['A', 'B'], '', [], '  ', ['', '  ']]))->toBe('A&B');
    });
})->group('builders');


describe('FunctionBuilder', function () {
    test('???', function () {
        // var_dump(buildFunction()->type());
    });
})->group('builders');
