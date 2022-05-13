<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ArrayFormatterInterface.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\complex;

use iomywiab\iomywiab_php_constraints\formatter\FormatterInterface;

/**
 * ArrayFormatter -> ItemFormatter
 * MessageFormatter -> ArrayFormatter
 * ItemFormatter -> all formatters
 * @psalm-immutable
 */
interface ArrayFormatterInterface extends FormatterInterface
{
    /**
     * @param array $array
     * @return string
     */
    public function toString(array $array): string;

    /**
     * @return ArrayKeyFormatting
     */
    public function getArrayKeyFormatting(): ArrayKeyFormatting;

    /**
     * @return string
     */
    public function getItemSeparator(): string;

    /**
     * @return string
     */
    public function getItemAssigner(): string;

    /**
     * @param ArrayKeyFormatting $arrayKeyFormatting
     * @return static
     */
    public function withArrayKeyFormatting(ArrayKeyFormatting $arrayKeyFormatting): static;

    /**
     * @param string $itemSeparator
     * @return static
     */
    public function withItemSeparator(string $itemSeparator): static;

    /**
     * @param string $itemAssigner
     * @return static
     */
    public function withItemAssigner(string $itemAssigner): static;
}
