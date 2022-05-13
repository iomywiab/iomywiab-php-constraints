<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: LengthFormatterInterface.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\simple;

use iomywiab\iomywiab_php_constraints\formatter\FormatterInterface;

/**
 * @psalm-immutable
 */
interface LengthFormatterInterface extends FormatterInterface
{
    /**
     * @param string $string
     * @return string
     */
    public function toString(string $string): string;

    /**
     * @return string
     */
    public function getAppendixString(): string;

    /**
     * @param string $appendixString
     * @return static
     */
    public function withAppendixString(string $appendixString): static;

    /**
     * @return int
     */
    public function getAppendixLength(): int;

    /**
     * @return int
     */
    public function getMaxLength(): int;

    /**
     * @param int $maxLength
     * @return static
     */
    public function withMaxLength(int $maxLength): static;
}
