<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: FormatterInterface.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter;

/**
 * @psalm-immutable
 */
interface FormatterInterface
{
    /**
     * @return string
     */
    public function getPrefix(): string;

    /**
     * @return string
     */
    public function getPostfix(): string;

    /**
     * @param string $prefix
     * @return static
     */
    public function withPrefix(string $prefix): static;

    /**
     * @param string $postfix
     * @return static
     */
    public function withPostfix(string $postfix): static;
}
