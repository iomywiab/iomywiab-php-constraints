<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: TypeFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 17:54:15
 * Version......: v2
 */

/** @noinspection MessDetectorValidationInspection */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotNull;
use iomywiab\iomywiab_php_constraints\formatter\simple\TypeFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\TypeFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class TypeFormatterTest extends TestCase
{
    /**
     * @param string $value
     * @param string $expected
     * @return void
     * @dataProvider valuesProvider
     */
    public function testDefault(
        mixed $value,
        string $expected
    ): void {
        $formatter = new TypeFormatter();
        self::assertSame($expected, $formatter->toString($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function valuesProvider(): array
    {
        $name = __DIR__ . '/../../../logs/unit-test.txt';
        $fileClosed = fopen($name, 'rb');
        fclose($fileClosed);
        return [
            [null, 'NULL'],
            [true, 'boolean'],
            [2.3, 'double'],
            [0, 'integer'],
            ['abc', 'string(3)'],
            [[], 'array(0)'],
            [STDOUT, 'resource'],
            [$fileClosed, 'resource (closed)'],
            [new \stdClass(), 'object'],
            [new IsNotNull(), 'object'],
        ];
    }

    /**
     * @param TypeFormatterInterface $formatter
     * @param string                 $arrayString
     * @param string                 $booleanString
     * @param string                 $floatString
     * @param string                 $integerString
     * @param string                 $nullString
     * @param string                 $objectString
     * @param string                 $resourceString
     * @param string                 $closedResourceString
     * @param string                 $stringString
     * @param string                 $unknownString
     * @param string                 $prefix
     * @param string                 $postfix
     * @return void
     * @noinspection PhpTooManyParametersInspection
     */
    protected function checkFormatter(
        TypeFormatterInterface $formatter,
        string $arrayString,
        string $booleanString,
        string $floatString,
        string $integerString,
        string $nullString,
        string $objectString,
        string $resourceString,
        string $closedResourceString,
        string $stringString,
        string $unknownString,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($arrayString, $formatter->getArrayString());
        self::assertSame($booleanString, $formatter->getBooleanString());
        self::assertSame($floatString, $formatter->getFloatString());
        self::assertSame($integerString, $formatter->getIntegerString());
        self::assertSame($nullString, $formatter->getNullString());
        self::assertSame($objectString, $formatter->getObjectString());
        self::assertSame($resourceString, $formatter->getResourceString());
        self::assertSame($closedResourceString, $formatter->getClosedResourceString());
        self::assertSame($stringString, $formatter->getStringString());
        self::assertSame($unknownString, $formatter->getUnknownString());
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testArrayString(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withArrayString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'x', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
    }

    /**
     * @return void
     */
    public function testBooleanString(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withBooleanString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'a', 'x', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
    }

    /**
     * @return void
     */
    public function testFloatString(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withFloatString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'a', 'b', 'x', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
    }

    /**
     * @return void
     */
    public function testIntegerString(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withIntegerString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'x', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
    }

    /**
     * @return void
     */
    public function testNullString(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withNullString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'x', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
    }

    /**
     * @return void
     */
    public function testObjectString(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withObjectString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'e', 'x', 'g', 'h', 'i', 'j', 'k', 'l');
    }

    /**
     * @return void
     */
    public function testResourceString(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withResourceString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'e', 'f', 'x', 'h', 'i', 'j', 'k', 'l');
    }

    /**
     * @return void
     */
    public function testClosedResource(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withClosedResourceString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'x', 'i', 'j', 'k', 'l');
    }

    /**
     * @return void
     */
    public function testStringString(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withStringString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'x', 'j', 'k', 'l');
    }

    /**
     * @return void
     */
    public function testUnknownString(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withUnknownString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'x', 'k', 'l');
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'x', 'l');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $formatter1 = new TypeFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'x');
    }
}
