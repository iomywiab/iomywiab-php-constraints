<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: NullFormatterInterface.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\simple;

use iomywiab\iomywiab_php_constraints\formatter\FormatterInterface;

/**
 * @psalm-immutable
 */
interface NullFormatterInterface extends FormatterInterface
{
    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @return string
     */
    public function getNullString(): string;

    /**
     * @param string $nullString
     * @return static
     */
    public function withNullString(string $nullString): static;
}
