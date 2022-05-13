<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: NumberFormatterInterface.php
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
interface NumberFormatterInterface extends FormatterInterface
{
    /**
     * @return string
     */
    public function getPlusPrefix(): string;

    /**
     * @return string
     */
    public function getPlusPostfix(): string;

    /**
     * @return string
     */
    public function getMinusPrefix(): string;

    /**
     * @return string
     */
    public function getMinusPostfix(): string;

    /**
     * @param string $plusPrefix
     * @return static
     */
    public function withPlusPrefix(string $plusPrefix): static;

    /**
     * @param string $plusPostfix
     * @return static
     */
    public function withPlusPostfix(string $plusPostfix): static;

    /**
     * @param string $minusPrefix
     * @return static
     */
    public function withMinusPrefix(string $minusPrefix): static;

    /**
     * @param string $minusPostfix
     * @return static
     */
    public function withMinusPostfix(string $minusPostfix): static;
}
