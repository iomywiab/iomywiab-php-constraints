<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: LengthFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 20:20:54
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\simple;

use iomywiab\iomywiab_php_constraints\formatter\simple\LengthFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\LengthFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class LengthFormatterTest extends TestCase
{
    /**
     * @param string $value
     * @param int    $length
     * @param string $expected
     * @return void
     * @dataProvider valuesProvider
     */
    public function testValues(
        mixed $value,
        int $length,
        string $expected
    ): void {
        $formatter = new LengthFormatter($length);
        self::assertSame($expected, $formatter->toString($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function valuesProvider(): array
    {
        return [
            ['', 7, ''],
            ['abc456', 7, 'abc456'],
            ['abc4567', 7, 'abc4567'],
            ['abc45678', 7, 'abc4...'],
        ];
    }

    /**
     * @param LengthFormatterInterface $formatter
     * @param int                      $maxLength
     * @param string                   $appendixString
     * @param string                   $prefix
     * @param string                   $postfix
     * @return void
     */
    protected function checkFormatter(
        LengthFormatterInterface $formatter,
        int $maxLength,
        string $appendixString,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($maxLength, $formatter->getMaxLength());
        self::assertSame($appendixString, $formatter->getAppendixString());
        self::assertSame(\strlen($appendixString), $formatter->getAppendixLength());
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $formatter1 = new LengthFormatter(123, 'a', 'b', 'c');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, 123, 'a', 'b', 'c');
        $this->checkFormatter($formatter2, 123, 'a', 'x', 'c');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $formatter1 = new LengthFormatter(123, 'a', 'b', 'c');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, 123, 'a', 'b', 'c');
        $this->checkFormatter($formatter2, 123, 'a', 'b', 'x');
    }

    /**
     * @return void
     */
    public function testMaxLength(): void
    {
        $formatter1 = new LengthFormatter(123, 'a', 'b', 'c');
        $formatter2 = $formatter1->withMaxLength(456);
        $this->checkFormatter($formatter1, 123, 'a', 'b', 'c');
        $this->checkFormatter($formatter2, 456, 'a', 'b', 'c');
    }

    /**
     * @return void
     */
    public function testAppendixString(): void
    {
        $formatter1 = new LengthFormatter(123, 'a', 'b', 'c');
        $formatter2 = $formatter1->withAppendixString('x');
        $this->checkFormatter($formatter1, 123, 'a', 'b', 'c');
        $this->checkFormatter($formatter2, 123, 'x', 'b', 'c');
    }
}
