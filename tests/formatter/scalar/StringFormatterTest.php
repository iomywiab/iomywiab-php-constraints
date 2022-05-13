<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: StringFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-12 17:24:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\scalar;

use iomywiab\iomywiab_php_constraints\formatter\scalar\StringFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\StringFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class StringFormatterTest extends TestCase
{
    /**
     * @param string|null $prefix
     * @param string|null $postfix
     * @param string      $value
     * @param string      $expected
     * @return void
     * @dataProvider valuesProvider
     */
    public function testValues(
        ?string $prefix,
        ?string $postfix,
        string $value,
        string $expected
    ): void {
        $formatter = new StringFormatter($prefix, $postfix);
        self::assertSame($expected, $formatter->toString($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function valuesProvider(): array
    {
        return [
            [null, null, '', '""'],
            [null, null, 'a', '"a"'],
            [null, null, 'abc', '"abc"'],

            ['[', ']', '', '[]'],
            ['[', ']', 'a', '[a]'],
            ['[', ']', 'abc', '[abc]'],
        ];
    }

    /**
     * @param StringFormatterInterface $formatter
     * @param string                   $prefix
     * @param string                   $postfix
     * @return void
     */
    protected function checkFormatter(
        StringFormatterInterface $formatter,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $formatter1 = new StringFormatter('a', 'b');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b');
        $this->checkFormatter($formatter2, 'x', 'b');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $formatter1 = new StringFormatter('a', 'b');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b');
        $this->checkFormatter($formatter2, 'a', 'x');
    }
}
