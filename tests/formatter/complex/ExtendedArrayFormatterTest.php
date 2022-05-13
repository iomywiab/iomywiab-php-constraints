<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ExtendedArrayFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 17:52:43
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\complex;

use iomywiab\iomywiab_php_constraints\formatter\complex\ArrayKeyFormatting;
use iomywiab\iomywiab_php_constraints\formatter\complex\ExtendedArrayFormatter;
use iomywiab\iomywiab_php_constraints\formatter\complex\ExtendedArrayFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\complex\ItemFormatter;
use iomywiab\iomywiab_php_constraints\formatter\complex\ItemFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 */
class ExtendedArrayFormatterTest extends TestCase
{
    /**
     * @param ItemFormatter|null      $itemFormatter
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
        ?ItemFormatterInterface $itemFormatter,
        ?ArrayKeyFormatting $arrayKeyFormatting,
        ?string $itemSeparator,
        ?string $itemAssigner,
        ?string $prefix,
        ?string $postfix,
        array $value,
        string $expected
    ): void {
        $formatter = new ExtendedArrayFormatter(
            $itemFormatter,
            $arrayKeyFormatting,
            $itemSeparator,
            $itemAssigner,
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
        $itemFormatter = new ItemFormatter();
        return [
            [null, null, null, null, null, null, ['a'], '["a"]'],
            [null, null, null, null, null, null, ['a', 'b'], '["a","b"]'],
            [null, null, null, null, null, null, ['a', 'key' => 'b', 'c'], '["a",key=>"b",1=>"c"]'],
            [null, null, null, null, null, null, ['a', 'key' => 'b', 7 => 'c'], '["a",key=>"b",7=>"c"]'],

            [$itemFormatter, null, '; ', '-->', '((', '))', ['a'], '(("a"))'],
            [$itemFormatter, null, '; ', '-->', '((', '))', ['a', 'b'], '(("a"; "b"))'],
            [$itemFormatter, null, '; ', '-->', '((', '))', ['a', 'key' => 'b', 'c'], '(("a"; key-->"b"; 1-->"c"))'],
            [
                $itemFormatter,
                null,
                '; ',
                '-->',
                '((',
                '))',
                ['a', 'key' => 'b', 7 => 'c'],
                '(("a"; key-->"b"; 7-->"c"))'
            ],
        ];
    }

    /**
     * @param ExtendedArrayFormatterInterface $formatter
     * @param ItemFormatterInterface          $itemFormatter
     * @param ArrayKeyFormatting              $arrayKeyFormatting
     * @param string                          $itemSeparator
     * @param string                          $itemAssigner
     * @param string                          $prefix
     * @param string                          $postfix
     * @return void
     * @noinspection PhpTooManyParametersInspection
     */
    protected function checkFormatter(
        ExtendedArrayFormatterInterface $formatter,
        ItemFormatterInterface $itemFormatter,
        ArrayKeyFormatting $arrayKeyFormatting,
        string $itemSeparator,
        string $itemAssigner,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($itemFormatter, $formatter->getItemFormatter());
        self::assertSame($arrayKeyFormatting, $formatter->getArrayKeyFormatting());
        self::assertSame($itemSeparator, $formatter->getItemSeparator());
        self::assertSame($itemAssigner, $formatter->getItemAssigner());
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testItemFormatter(): void
    {
        $itemFormatter1 = new ItemFormatter(true);
        $itemFormatter2 = new ItemFormatter(false);
        $formatter1 = new ExtendedArrayFormatter($itemFormatter1, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withItemFormatter($itemFormatter2);
        $this->checkFormatter($formatter1, $itemFormatter1, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, $itemFormatter2, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testArrayKeyFormatting(): void
    {
        $itemFormatter = new ItemFormatter();
        $formatter1 = new ExtendedArrayFormatter($itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withArrayKeyFormatting(ArrayKeyFormatting::INCLUDE_KEYS);
        $this->checkFormatter($formatter1, $itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, $itemFormatter, ArrayKeyFormatting::INCLUDE_KEYS, 'a', 'b', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testItemSeparator(): void
    {
        $itemFormatter = new ItemFormatter();
        $formatter1 = new ExtendedArrayFormatter($itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withItemSeparator('x');
        $this->checkFormatter($formatter1, $itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, $itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'x', 'b', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testItemAssigner(): void
    {
        $itemFormatter = new ItemFormatter();
        $formatter1 = new ExtendedArrayFormatter($itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withItemAssigner('x');
        $this->checkFormatter($formatter1, $itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, $itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'x', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $itemFormatter = new ItemFormatter();
        $formatter1 = new ExtendedArrayFormatter($itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, $itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, $itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'x', 'd');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $itemFormatter = new ItemFormatter();
        $formatter1 = new ExtendedArrayFormatter($itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, $itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, $itemFormatter, ArrayKeyFormatting::EXCLUDE_KEYS, 'a', 'b', 'c', 'x');
    }
}
