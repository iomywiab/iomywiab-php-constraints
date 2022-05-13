<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: MessageFormatterInterface.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\complex;

use iomywiab\iomywiab_php_constraints\formatter\FormatterInterface;

/**
 * @psalm-immutable
 */
interface MessageFormatterInterface extends FormatterInterface
{
    /**
     * @param string     $message
     * @param array|null $values
     * @return string
     */
    public function toString(string $message, ?array $values = null): string;

    /**
     * @return ArrayFormatterInterface
     */
    public function getArrayFormatter(): ArrayFormatterInterface;

    /**
     * @param ArrayFormatterInterface $arrayFormatter
     * @return static
     */
    public function withArrayFormatter(ArrayFormatterInterface $arrayFormatter): static;
}
