<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: BooleanFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-12 17:22:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\scalar;

use iomywiab\iomywiab_php_constraints\formatter\scalar\BooleanFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\BooleanFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class BooleanFormatterTest extends TestCase
{
    /**
     * @param string|null $trueString
     * @param string|null $falseString
     * @param string|null $prefix
     * @param string|null $postfix
     * @param bool        $value
     * @param string      $expected
     * @return void
     * @dataProvider valuesProvider
     * @noinspection PhpTooManyParametersInspection
     */
    public function testValues(
        ?string $trueString,
        ?string $falseString,
        ?string $prefix,
        ?string $postfix,
        bool $value,
        string $expected
    ): void {
        $formatter = new BooleanFormatter($trueString, $falseString, $prefix, $postfix);
        self::assertSame($expected, $formatter->toString($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function valuesProvider(): array
    {
        return [
            [null, null, null, null, true, BooleanFormatter::DEFAULT_TRUE_STRING],
            [null, null, null, null, false, BooleanFormatter::DEFAULT_FALSE_STRING],
            ['yes', 'no', '[', ']', true, '[yes]'],
            ['ja', 'nein', '<', '>', false, '<nein>'],
        ];
    }

    /**
     * @param BooleanFormatterInterface $formatter
     * @param string                    $expectedTrueString
     * @param string                    $expectedFalseString
     * @param string                    $expectedPrefix
     * @param string                    $expectedPostfix
     * @return void
     */
    protected function checkFormatter(
        BooleanFormatterInterface $formatter,
        string $expectedTrueString,
        string $expectedFalseString,
        string $expectedPrefix,
        string $expectedPostfix
    ): void {
        self::assertSame($expectedTrueString, $formatter->getTrueString());
        self::assertSame($expectedFalseString, $formatter->getFalseString());
        self::assertSame($expectedPrefix, $formatter->getPrefix());
        self::assertSame($expectedPostfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testTrueString(): void
    {
        $formatter1 = new BooleanFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withTrueString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'x', 'b', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testFalseString(): void
    {
        $formatter1 = new BooleanFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withFalseString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'a', 'x', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $formatter1 = new BooleanFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'a', 'b', 'x', 'd');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $formatter1 = new BooleanFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'x');
    }
}
