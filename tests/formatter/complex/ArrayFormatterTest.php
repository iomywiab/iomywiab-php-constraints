<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ArrayFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 13:07:26
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\complex;

use iomywiab\iomywiab_php_constraints\formatter\complex\ArrayFormatter;
use iomywiab\iomywiab_php_constraints\formatter\complex\ArrayFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\complex\ArrayKeyFormatting;
use PHPUnit\Framework\TestCase;

/**
 */
class ArrayFormatterTest extends TestCase
{
    /**
     * @param ArrayKeyFormatting|null $arrayKeyFormatting
     * @param string|null             $itemSeparator
     * @param string|null             $itemAssigner
     * @param string|null             $prefix
     * @param string|null             $postfix
     * @param array                   $value
     * @param string                  $expected
     * @return void
     * @dataProvider valuesProvider
     * @noinspection PhpTooManyParametersInspection
     */
    public function testValues(
        ?ArrayKeyFormatting $arrayKeyFormatting,
        ?string $itemSeparator,
        ?string $itemAssigner,
        ?string $prefix,
        ?string $postfix,
        array $value,
        string $expected
    ): void {
        $formatter = new ArrayFormatter($arrayKeyFormatting, $itemSeparator, $itemAssigner, $prefix, $postfix);
        self::assertSame($expected, $formatter->toString($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function valuesProvider(): array
    {
        return [
            [null, null, null, null, null, ['a'], '[a]'],
            [null, null, null, null, null, ['a', 'b'], '[a,b]'],
            [null, null, null, null, null, ['a', 'key' => 'b', 'c'], '[a,key=>b,1=>c]'],
            [null, null, null, null, null, ['a', 'key' => 'b', 7 => 'c'], '[a,key=>b,7=>c]'],

            [null, '; ', '-->', '((', '))', ['a'], '((a))'],
            [null, '; ', '-->', '((', '))', ['a', 'b'], '((a; b))'],
            [null, '; ', '-->', '((', '))', ['a', 'key' => 'b', 'c'], '((a; key-->b; 1-->c))'],
            [null, '; ', '-->', '((', '))', ['a', 'key' => 'b', 7 => 'c'], '((a; key-->b; 7-->c))'],
        ];
    }

    /**
     * @param ArrayFormatterInterface $formatter
     * @param ArrayKeyFormatting      $arrayKeyFormatting
     * @param string                  $itemSeparator
     * @param string                  $itemAssigner
     * @param string                  $prefix
     * @param string                  $postfix
     * @return void
     * @noinspection PhpTooManyParametersInspection
     */
    protected function checkFormatter(
        ArrayFormatterInterface $formatter,
        ArrayKeyFormatting $arrayKeyFormatting,
        string $itemSeparator,
        string $itemAssigner,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($arrayKeyFormatting, $formatter->getArrayKeyFormatting());
        self::assertSame($itemSeparator, $formatter->getItemSeparator());
        self::assertSame($itemAssigner, $formatter->getItemAssigner());
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testArrayKeyFormatting(): void
    {
        $formatter1 = new ArrayFormatter(ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withArrayKeyFormatting(ArrayKeyFormatting::INCLUDE_KEYS);
        $this->checkFormatter($formatter1, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter1, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, ArrayKeyFormatting::INCLUDE_KEYS, 'a', 'b', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testItemSeparator(): void
    {
        $formatter1 = new ArrayFormatter(ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withItemSeparator('x');
        $this->checkFormatter($formatter1, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, ArrayKeyFormatting::EXCLUDE_KEYS, 'x', 'b', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testItemAssigner(): void
    {
        $formatter1 = new ArrayFormatter(ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withItemAssigner('x');
        $this->checkFormatter($formatter1, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'x', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $formatter1 = new ArrayFormatter(ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'x', 'd');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $formatter1 = new ArrayFormatter(ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'x');
    }
}
