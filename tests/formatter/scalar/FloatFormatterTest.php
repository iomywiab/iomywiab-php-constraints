<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: FloatFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-12 17:24:31
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\scalar;

use iomywiab\iomywiab_php_constraints\formatter\scalar\FloatFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\FloatFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class FloatFormatterTest extends TestCase
{
    /**
     * @param string|null $plusPrefix
     * @param string|null $minusPrefix
     * @param string|null $plusPostfix
     * @param string|null $minusPostfix
     * @param string|null $integerPostfix
     * @param string|null $prefix
     * @param string|null $postfix
     * @param float       $value
     * @param string      $expected
     * @return void
     * @dataProvider valuesProvider
     * @noinspection PhpTooManyParametersInspection
     */
    public function testValues(
        ?string $plusPrefix,
        ?string $minusPrefix,
        ?string $plusPostfix,
        ?string $minusPostfix,
        ?string $integerPostfix,
        ?string $prefix,
        ?string $postfix,
        float $value,
        string $expected
    ): void {
        $formatter = new FloatFormatter(
            $plusPrefix,
            $minusPrefix,
            $plusPostfix,
            $minusPostfix,
            $integerPostfix,
            $prefix,
            $postfix
        );
        self::assertSame($expected, $formatter->toString($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function valuesProvider(): array
    {
        return [
            [null, null, null, null, null, null, null, -PHP_FLOAT_MAX, '-1.7976931348623E+308'],
            [null, null, null, null, null, null, null, -2.3, '-2.3'],
            [null, null, null, null, null, null, null, -1.0, '-1.0'],
            [null, null, null, null, null, null, null, 0.0, '0.0'],
            [null, null, null, null, null, null, null, 1.0, '1.0'],
            [null, null, null, null, null, null, null, 2.3, '2.3'],
            [null, null, null, null, null, null, null, PHP_FLOAT_MAX, '1.7976931348623E+308'],

            ['+', '--', 'pp', 'mm', '.0', '[', ']', -PHP_FLOAT_MAX, '[--1.7976931348623E+308mm]'],
            ['+', '--', 'pp', 'mm', '.0', '[', ']', -2.3, '[--2.3mm]'],
            ['+', '--', 'pp', 'mm', '.0', '[', ']', -1.0, '[--1.0mm]'],
            ['+', '--', 'pp', 'mm', '.0', '[', ']', 0.0, '[0.0]'],
            ['+', '--', 'pp', 'mm', '.0', '[', ']', 1.0, '[+1.0pp]'],
            ['+', '--', 'pp', 'mm', '.0', '[', ']', 2.3, '[+2.3pp]'],
            ['+', '--', 'pp', 'mm', '.0', '[', ']', PHP_FLOAT_MAX, '[+1.7976931348623E+308pp]'],
        ];
    }

    /**
     * @param FloatFormatterInterface $formatter
     * @param string                  $plusPrefix
     * @param string                  $minusPrefix
     * @param string                  $plusPostfix
     * @param string                  $minusPostfix
     * @param string                  $integerPostfix
     * @param string                  $prefix
     * @param string                  $postfix
     * @return void
     * @noinspection PhpTooManyParametersInspection
     */
    protected function checkFormatter(
        FloatFormatterInterface $formatter,
        string $plusPrefix,
        string $minusPrefix,
        string $plusPostfix,
        string $minusPostfix,
        string $integerPostfix,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($plusPrefix, $formatter->getPlusPrefix());
        self::assertSame($minusPrefix, $formatter->getMinusPrefix());
        self::assertSame($plusPostfix, $formatter->getPlusPostfix());
        self::assertSame($minusPostfix, $formatter->getMinusPostfix());
        self::assertSame($integerPostfix, $formatter->getIntegerPostfix());
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testPlusPrefix(): void
    {
        $formatter1 = new FloatFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g');
        $formatter2 = $formatter1->withPlusPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g');
        $this->checkFormatter($formatter2, 'x', 'b', 'c', 'd', 'e', 'f', 'g');
    }

    /**
     * @return void
     */
    public function testMinusPrefix(): void
    {
        $formatter1 = new FloatFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g');
        $formatter2 = $formatter1->withMinusPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g');
        $this->checkFormatter($formatter2, 'a', 'x', 'c', 'd', 'e', 'f', 'g');
    }

    /**
     * @return void
     */
    public function testPlusPostfix(): void
    {
        $formatter1 = new FloatFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g');
        $formatter2 = $formatter1->withPlusPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g');
        $this->checkFormatter($formatter2, 'a', 'b', 'x', 'd', 'e', 'f', 'g');
    }

    /**
     * @return void
     */
    public function testMinusPostfix(): void
    {
        $formatter1 = new FloatFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g');
        $formatter2 = $formatter1->withMinusPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'x', 'e', 'f', 'g');
    }

    /**
     * @return void
     */
    public function testIntegerPostfix(): void
    {
        $formatter1 = new FloatFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g');
        $formatter2 = $formatter1->withIntegerPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'x', 'f', 'g');
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $formatter1 = new FloatFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'e', 'x', 'g');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $formatter1 = new FloatFormatter('a', 'b', 'c', 'd', 'e', 'f', 'g');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f', 'g');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'e', 'f', 'x');
    }
}
