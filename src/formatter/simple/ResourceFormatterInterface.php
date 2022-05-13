<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ResourceFormatterInterface.php
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
interface ResourceFormatterInterface extends FormatterInterface
{
    /**
     * @param resource $resource
     * @return string
     */
    public function toString(mixed $resource): string;

    /**
     * @return string
     */
    public function getIdPrefix(): string;

    /**
     * @return string
     */
    public function getIdPostfix(): string;

    /**
     * @param string $idPrefix
     * @return static
     */
    public function withIdPrefix(string $idPrefix): static;

    /**
     * @param string $idPostfix
     * @return static
     */
    public function withIdPostfix(string $idPostfix): static;
}
