<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: BooleanFormatterInterface.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\scalar;

use iomywiab\iomywiab_php_constraints\formatter\FormatterInterface;

/**
 * @psalm-immutable
 */
interface BooleanFormatterInterface extends FormatterInterface
{
    /**
     * @param bool $boolean
     * @return string
     */
    public function toString(bool $boolean): string;

    /**
     * @return string
     */
    public function getTrueString(): string;

    /**
     * @return string
     */
    public function getFalseString(): string;

    /**
     * @param string $trueString
     * @return $this
     */
    public function withTrueString(string $trueString): static;

    /**
     * @param string $falseString
     * @return $this
     */
    public function withFalseString(string $falseString): static;
}
