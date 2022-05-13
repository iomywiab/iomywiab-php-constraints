<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: FormatTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 20:33:45
 * Version......: v2
 */

/** @noinspection RedundantSuppression */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\complex;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotNull;
use iomywiab\iomywiab_php_constraints\formatter\complex\Format;
use iomywiab\iomywiab_php_constraints\formatter\scalar\BooleanFormatter;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 */
class FormatTest extends TestCase
{
    /**
     * @param mixed  $value
     * @param string $expected
     * @return void
     * @dataProvider stringProvider
     * @noinspection MessDetectorValidationInspection
     */
    public function testToString(mixed $value, string $expected): void
    {
        if (23 === $this->dataName()) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $breakpoint = true;
        }
        self::assertSame($expected, Format::toString($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function stringProvider(): array
    {
        $name = __DIR__ . '/../../../logs/unit-test.txt';
        $fileClosed = fopen($name, 'rb');
        fclose($fileClosed);
        $fileOpened = fopen($name, 'rb');
        $idSTDOUT = \get_resource_id(STDOUT);
        $idFileOpened = \get_resource_id($fileOpened);
        $idFileClosed = \get_resource_id($fileClosed);

        return [
            [['a'], '["a"]'],
            [['a', 'b'], '["a","b"]'],
            [['a', 'key' => 'b', 'c'], '["a",key=>"b",1=>"c"]'],
            [['a', 'key' => 'b', 7 => 'c'], '["a",key=>"b",7=>"c"]'],

            [true, BooleanFormatter::DEFAULT_TRUE_STRING],
            [false, BooleanFormatter::DEFAULT_FALSE_STRING],

            [-PHP_FLOAT_MAX, '-1.7976931348623E+308'],
            [-2.3, '-2.3'],
            [-1.0, '-1.0'],
            [0.0, '0.0'],
            [1.0, '1.0'],
            [2.3, '2.3'],
            [PHP_FLOAT_MAX, '1.7976931348623E+308'],

            [PHP_INT_MIN, '-9.2233720368548E+18'],
            [-1, '-1'],
            [0, '0'],
            [1, '1'],
            [PHP_INT_MAX, '9223372036854775807'],

            [new \stdClass(), 'stdClass'],
            [new IsNotNull(), 'IsNotNull'],
            [new \DateTime('1970-09-02'), 'DateTime:[1970-09-02T00:00:00+00:00]'],

            [STDOUT, 'stream(id=' . $idSTDOUT . ')'],
            [$fileOpened, 'stream(id=' . $idFileOpened . ')'],
            [$fileClosed, 'Unknown(id=' . $idFileClosed . ')'],

            ['', '""'],
            ['a', '"a"'],
            ['abc', '"abc"'],
        ];
    }

    /**
     * @param mixed  $value
     * @param string $expected
     * @return void
     * @dataProvider debugStringProvider
     */
    public function testToDebugString(mixed $value, string $expected): void
    {
        if (23 === $this->dataName()) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $breakpoint = true;
        }
        self::assertSame($expected, Format::toDebugString($value));
    }

    /**
     * @return array
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function debugStringProvider(): array
    {
        $name = __DIR__ . '/../../../logs/unit-test.txt';
        $fileClosed = fopen($name, 'rb');
        fclose($fileClosed);
        $fileOpened = fopen($name, 'rb');
        $idSTDOUT = \get_resource_id(STDOUT);
        $idFileOpened = \get_resource_id($fileOpened);
        $idFileClosed = \get_resource_id($fileClosed);

        return [
            [['a'], 'array(1):[string(1):"a"]'],
            [['a', 'b'], 'array(2):[string(1):"a",string(1):"b"]'],
            [['a', 'key' => 'b', 'c'], 'array(3):[string(1):"a",key=>string(1):"b",1=>string(1):"c"]'],
            [['a', 'key' => 'b', 7 => 'c'], 'array(3):[string(1):"a",key=>string(1):"b",7=>string(1):"c"]'],

            [true, 'bool:true'],
            [false, 'bool:false'],

            [-PHP_FLOAT_MAX, 'float:-1.7976931348623E+308'],
            [-2.3, 'float:-2.3'],
            [-1.0, 'float:-1.0'],
            [0.0, 'float:0.0'],
            [1.0, 'float:1.0'],
            [2.3, 'float:2.3'],
            [PHP_FLOAT_MAX, 'float:1.7976931348623E+308'],

            [PHP_INT_MIN, 'int:-9.2233720368548E+18'],
            [-1, 'int:-1'],
            [0, 'int:0'],
            [1, 'int:1'],
            [PHP_INT_MAX, 'int:9223372036854775807'],

            [new \stdClass(), 'object:stdClass'],
            [new IsNotNull(), 'object:IsNotNull'],
            [new \DateTime('1970-09-02'), 'object:DateTime:[1970-09-02T00:00:00+00:00]'],

            [STDOUT, 'resource:stream(id=' . $idSTDOUT . ')'],
            [$fileOpened, 'resource:stream(id=' . $idFileOpened . ')'],
            [$fileClosed, 'resource (closed):Unknown(id=' . $idFileClosed . ')'],

            ['', 'string(0):""'],
            ['a', 'string(1):"a"'],
            ['abc', 'string(3):"abc"'],
        ];
    }

    /**
     * @param string $message
     * @param array  $values
     * @param string $expected
     * @return void
     * @dataProvider messageProvider
     */
    public function testToMessage(string $message, array $values, string $expected): void
    {
        self::assertSame($expected, Format::toMessage($message, $values));
    }

    /**
     * @return array<int,array<int,mixed>>
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function messageProvider(): array
    {
        return [
            ['test-message1', [], 'test-message1.'],
            ['test-message2.', [], 'test-message2.'],

            ['', ['expected' => 0, 'got' => 1], '[expected=>int:0,got=>int:1]'],

            ['test-message3', ['expected' => 0, 'got' => 1], 'test-message3. [expected=>int:0,got=>int:1]'],
            ['test-message4.', ['expected' => 0, 'got' => 1], 'test-message4. [expected=>int:0,got=>int:1]'],
        ];
    }

    /**
     * @param array<int, mixed> $list
     * @param string $expected
     * @return void
     * @dataProvider valueListProvider
     */
    public function testToValueList(array $list, string $expected): void
    {
        self::assertSame($expected, Format::toValueList($list));
    }

    /**
     * @return array<int,array>int,mixed>>
     */
    public function valueListProvider(): array
    {
        return [
            [[], ''],
            [[1], '1'],
            [[1,true], '1|true'],
            [[1,true,'0',2.3], '1|true|0|2.3'],
        ];
    }

    /**
     * @throws ExpectationFailedException
     */
    public function testMaxLength(): void
    {
        $value = ['one', 'two'];
        self::assertSame('one|two', Format::toValueList($value));
        self::assertSame('one|two', Format::toValueList($value, 8));
        self::assertSame('one...', Format::toValueList($value, 6));
        self::assertSame('on...', Format::toValueList($value, 5));
        self::assertSame('o...', Format::toValueList($value, 4));


        self::assertSame('["one","two"]', Format::toString($value));
        self::assertSame('["one",...', Format::toString($value, 10));
        self::assertSame('["on...', Format::toString($value, 7));
        self::assertSame('["o...', Format::toString($value, 6));
        self::assertSame('["...', Format::toString($value, 5));
        self::assertSame('[...', Format::toString($value, 4));

        self::assertSame('null', Format::toDebugString(null));
        self::assertSame('null', Format::toDebugString(null, 5));
        self::assertSame('null', Format::toDebugString(null, 4));

        self::assertSame('array(2):[string(3):"one",string(3):"two"]', Format::toDebugString($value));
        self::assertSame('array(2):[string(3):"one",string(3):"two"]', Format::toDebugString($value, 42));
        self::assertSame('array(2):[string(3):"one",string(3):"t...', Format::toDebugString($value, 41));
        self::assertSame('array(2):[string(3):"one",string(3):"...', Format::toDebugString($value, 40));
        self::assertSame('array(2):[string(3):"one",s...', Format::toDebugString($value, 30));
        self::assertSame('array(2):[string(...', Format::toDebugString($value, 20));
        self::assertSame('array(2...', Format::toDebugString($value, 10));
        self::assertSame('ar...', Format::toDebugString($value, 5));
        self::assertSame('a...', Format::toDebugString($value, 4));
    }
}
