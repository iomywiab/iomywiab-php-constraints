<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IntegerFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-12 17:24:39
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\scalar;

use iomywiab\iomywiab_php_constraints\formatter\scalar\IntegerFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\IntegerFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class IntegerFormatterTest extends TestCase
{
    /**
     * @param string|null $plusPrefix
     * @param string|null $minusPrefix
     * @param string|null $plusPostfix
     * @param string|null $minusPostfix
     * @param string|null $prefix
     * @param string|null $postfix
     * @param int         $value
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
        ?string $prefix,
        ?string $postfix,
        int $value,
        string $expected
    ): void {
        $formatter = new IntegerFormatter($plusPrefix, $minusPrefix, $plusPostfix, $minusPostfix, $prefix, $postfix);
        self::assertSame($expected, $formatter->toString($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function valuesProvider(): array
    {
        return [
            [null, null, null, null, null, null, PHP_INT_MIN, '-9.2233720368548E+18'],
            [null, null, null, null, null, null, -1, '-1'],
            [null, null, null, null, null, null, 0, '0'],
            [null, null, null, null, null, null, 1, '1'],
            [null, null, null, null, null, null, PHP_INT_MAX, '9223372036854775807'],

            ['+', '--', 'pp','mm', '[', ']', PHP_INT_MIN, '[--9.2233720368548E+18mm]'],
            ['+', '--', 'pp','mm', '[', ']', -1, '[--1mm]'],
            ['+', '--', 'pp','mm', '[', ']', 0, '[0]'],
            ['+', '--', 'pp','mm', '[', ']', 1, '[+1pp]'],
            ['+', '--', 'pp','mm', '[', ']', PHP_INT_MAX, '[+9223372036854775807pp]'],
        ];
    }

    /**
     * @param IntegerFormatterInterface $formatter
     * @param string                    $plusPrefix
     * @param string                    $minusPrefix
     * @param string                    $plusPostfix
     * @param string                    $minusPostfix
     * @param string                    $prefix
     * @param string                    $postfix
     * @return void
     * @noinspection PhpTooManyParametersInspection
     */
    protected function checkFormatter(
        IntegerFormatterInterface $formatter,
        string $plusPrefix,
        string $minusPrefix,
        string $plusPostfix,
        string $minusPostfix,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($plusPrefix, $formatter->getPlusPrefix());
        self::assertSame($minusPrefix, $formatter->getMinusPrefix());
        self::assertSame($plusPostfix, $formatter->getPlusPostfix());
        self::assertSame($minusPostfix, $formatter->getMinusPostfix());
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testPlusPrefix(): void
    {
        $formatter1 = new IntegerFormatter('a', 'b', 'c', 'd', 'e', 'f');
        $formatter2 = $formatter1->withPlusPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f');
        $this->checkFormatter($formatter2, 'x', 'b', 'c', 'd', 'e', 'f');
    }

    /**
     * @return void
     */
    public function testMinusPrefix(): void
    {
        $formatter1 = new IntegerFormatter('a', 'b', 'c', 'd', 'e', 'f');
        $formatter2 = $formatter1->withMinusPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f');
        $this->checkFormatter($formatter2, 'a', 'x', 'c', 'd', 'e', 'f');
    }

    /**
     * @return void
     */
    public function testPlusPostfix(): void
    {
        $formatter1 = new IntegerFormatter('a', 'b', 'c', 'd', 'e', 'f');
        $formatter2 = $formatter1->withPlusPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f');
        $this->checkFormatter($formatter2, 'a', 'b', 'x', 'd', 'e', 'f');
    }

    /**
     * @return void
     */
    public function testMinusPostfix(): void
    {
        $formatter1 = new IntegerFormatter('a', 'b', 'c', 'd', 'e', 'f');
        $formatter2 = $formatter1->withMinusPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'x', 'e', 'f');
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $formatter1 = new IntegerFormatter('a', 'b', 'c', 'd', 'e', 'f');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'x', 'f');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $formatter1 = new IntegerFormatter('a', 'b', 'c', 'd', 'e', 'f');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd', 'e', 'f');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'd', 'e', 'x');
    }
}
