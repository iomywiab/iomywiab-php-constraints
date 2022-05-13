<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: NullFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 17:55:16
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\simple;

use iomywiab\iomywiab_php_constraints\formatter\simple\NullFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\NullFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class NullFormatterTest extends TestCase
{
    /**
     * @return void
     */
    public function testDefault(): void
    {
        $formatter = new NullFormatter();
        self::assertSame('null', $formatter->toString());
    }

    /**
     * @return void
     */
    public function testFormatted(): void
    {
        $formatter = new NullFormatter('zero', '((', '))');
        self::assertSame('((zero))', $formatter->toString());
    }


    /**
     * @param NullFormatterInterface $formatter
     * @param string                 $nullString
     * @param string                 $prefix
     * @param string                 $postfix
     * @return void
     */
    protected function checkFormatter(
        NullFormatterInterface $formatter,
        string $nullString,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($nullString, $formatter->getNullString());
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testNullString(): void
    {
        $formatter1 = new NullFormatter('a', 'b', 'c');
        $formatter2 = $formatter1->withNullString('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c');
        $this->checkFormatter($formatter2, 'x', 'b', 'c');
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $formatter1 = new NullFormatter('a', 'b', 'c');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c');
        $this->checkFormatter($formatter2, 'a', 'x', 'c');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $formatter1 = new NullFormatter('a', 'b', 'c');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c');
        $this->checkFormatter($formatter2, 'a', 'b', 'x');
    }
}
