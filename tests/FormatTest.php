<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: FormatTest.php
 * Class name...: FormatTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:32:09
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests;

require_once __DIR__ . '/test.php';

use iomywiab\iomywiab_php_constraints\constraints\simple\IsArray;
use iomywiab\iomywiab_php_constraints\Format;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class FormatTest
 *
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class FormatTest extends TestCase
{

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testInteger(): void
    {
        $value = 123456;
        self::assertEquals('integer', Format::toShortClassName($value));
        self::assertEquals('integer', Format::toClassName($value));
        self::assertEquals('integer', Format::toType($value));
        self::assertEquals('123456', Format::toString($value));
        self::assertEquals('123456', Format::toString($value, 3));
        self::assertEquals('integer:[123456]', Format::toDescription($value));
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testBoolean(): void
    {
        $value = true;
        self::assertEquals('boolean', Format::toShortClassName($value));
        self::assertEquals('boolean', Format::toClassName($value));
        self::assertEquals('boolean', Format::toType($value));
        self::assertEquals('true', Format::toString($value));
        self::assertEquals('boolean:[true]', Format::toDescription($value));

        $value = false;
        self::assertEquals('boolean', Format::toShortClassName($value));
        self::assertEquals('boolean', Format::toClassName($value));
        self::assertEquals('boolean', Format::toType($value));
        self::assertEquals('false', Format::toString($value));
        self::assertEquals('boolean:[false]', Format::toDescription($value));
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testDouble(): void
    {
        $value = 12.345678;
        self::assertEquals('double', Format::toShortClassName($value));
        self::assertEquals('double', Format::toClassName($value));
        self::assertEquals('double', Format::toType($value));
        self::assertEquals('12.345678', Format::toString($value));
        self::assertEquals('double:[12.345678]', Format::toDescription($value));
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testString(): void
    {
        $value = 'Hello world';
        self::assertEquals('string', Format::toShortClassName($value));
        self::assertEquals('string', Format::toClassName($value));
        self::assertEquals('string', Format::toType($value));
        self::assertEquals('Hello world', Format::toString($value));
        self::assertEquals('"Hello world"', Format::toString($value, null, true));
        self::assertEquals('string:["Hello world"]', Format::toDescription($value));
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testArray(): void
    {
        $value = [0, 'string', 'key' => 'value', 3];
        self::assertEquals('array', Format::toShortClassName($value));
        self::assertEquals('array', Format::toClassName($value));
        self::assertEquals('array', Format::toType($value));
        self::assertEquals('[0,"string","key"=>"value",2=>3]', Format::toString($value));
        self::assertEquals('array:[0,"string","key"=>"value",2=>3]', Format::toDescription($value));
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testObject(): void
    {
        $value = new IsArray();
        self::assertEquals('IsArray', Format::toShortClassName($value));
        self::assertEquals('iomywiab\iomywiab_php_constraints\constraints\simple\IsArray', Format::toClassName($value));
        self::assertEquals('iomywiab\iomywiab_php_constraints\constraints\simple\IsArray', Format::toType($value));
        self::assertEquals('IsArray', Format::toString($value));
        self::assertEquals('object:IsArray', Format::toDescription($value));
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testNull(): void
    {
        $value = null;
        self::assertEquals('null', Format::toShortClassName($value));
        self::assertEquals('null', Format::toClassName($value));
        self::assertEquals('null', Format::toType($value));
        self::assertEquals('null', Format::toString($value));
        self::assertEquals('null', Format::toDescription($value));
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testResource(): void
    {
        $value = fopen('php://stdout', 'w');
        self::assertEquals('resource', Format::toShortClassName($value));
        self::assertEquals('resource', Format::toClassName($value));
        self::assertEquals('resource', Format::toType($value));
        self::assertEquals('stream', Format::toString($value));
        self::assertEquals('resource:[stream]', Format::toDescription($value));
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testValueList(): void
    {
        self::assertEquals('1', Format::toValueList([1]));
        self::assertEquals('1|two', Format::toValueList([1, 'two']));
        self::assertEquals('1|two|3', Format::toValueList([1, 'two', 3]));
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testMaxLength(): void
    {
        $value = ['one', 'two'];
        self::assertEquals('one|two', Format::toValueList($value));
        self::assertEquals('one|two', Format::toValueList($value, 8));
        self::assertEquals('one...', Format::toValueList($value, 6));
        self::assertEquals('on...', Format::toValueList($value, 5));
        self::assertEquals('o...', Format::toValueList($value, 4));
        self::assertEquals('one|two', Format::toValueList($value, 3));
        self::assertEquals('one|two', Format::toValueList($value, 2));

        self::assertEquals('["one","two"]', Format::toString($value));
        self::assertEquals('["one"...]', Format::toString($value, 10));
        self::assertEquals('["o...]', Format::toString($value, 7));
        self::assertEquals('["...]', Format::toString($value, 6));
        self::assertEquals('[...]', Format::toString($value, 5));
        self::assertEquals('["one","two"]', Format::toString($value, 4));
        self::assertEquals('["one","two"]', Format::toString($value, 3));
        self::assertEquals('["one","two"]', Format::toString($value, 2));

        self::assertEquals('"one","two"', Format::toString($value, null, false));
        self::assertEquals('"one"...', Format::toString($value, 8, false));
        self::assertEquals('"on...', Format::toString($value, 6, false));
        self::assertEquals('"o...', Format::toString($value, 5, false));
        self::assertEquals('"...', Format::toString($value, 4, false));
        self::assertEquals('"one","two"', Format::toString($value, 3, false));
        self::assertEquals('"one","two"', Format::toString($value, 2, false));

        self::assertEquals('null', Format::toDescription(null));
        self::assertEquals('null', Format::toDescription(null, 5));
        self::assertEquals('null', Format::toDescription(null, 4));
        self::assertEquals('null', Format::toDescription(null, 3));
        self::assertEquals('null', Format::toDescription(null, 2));
        self::assertEquals('null', Format::toDescription(null, 1));


        self::assertEquals('array:["one","two"]', Format::toDescription($value));
        self::assertEquals('array:["one","two"]', Format::toDescription($value, 19));
        self::assertEquals('array:["one","t...', Format::toDescription($value, 18));
        self::assertEquals('array:["one","...', Format::toDescription($value, 17));
        self::assertEquals('array:["one",...', Format::toDescription($value, 16));
        self::assertEquals('array:["one"...', Format::toDescription($value, 15));
        self::assertEquals('array:["one...', Format::toDescription($value, 14));
        self::assertEquals('array:["on...', Format::toDescription($value, 13));
        self::assertEquals('array:["o...', Format::toDescription($value, 12));
        self::assertEquals('array:["...', Format::toDescription($value, 11));
        self::assertEquals('array:[...', Format::toDescription($value, 10));
        self::assertEquals('array:...', Format::toDescription($value, 9));
        self::assertEquals('array...', Format::toDescription($value, 8));
        self::assertEquals('array', Format::toDescription($value, 7));
        self::assertEquals('array', Format::toDescription($value, 6));
        self::assertEquals('array', Format::toDescription($value, 5));
        self::assertEquals('a...', Format::toDescription($value, 4));
        self::assertEquals('array', Format::toDescription($value, 3));
        self::assertEquals('array', Format::toDescription($value, 2));
        self::assertEquals('array', Format::toDescription($value, 1));
    }
}
