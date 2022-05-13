<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ObjectFormatterInterface.php
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
interface ObjectFormatterInterface extends FormatterInterface
{
    /**
     * @param object $object
     * @return string
     */
    public function toString(object $object): string;

    /**
     * @param class-string|object $object
     * @return string
     * @throws \ReflectionException
     */
    public function toShortClassName(object|string $object): string;

    /**
     * @param class-string|object $object
     * @return string
     * @throws \ReflectionException
     */
    public function toClassName(object|string $object): string;

    /**
     * @return string
     */
    public function getValuePrefix(): string;

    /**
     * @return string
     */
    public function getValuePostfix(): string;

    /**
     * @param string $valuePrefix
     * @return static
     */
    public function withValuePrefix(string $valuePrefix): static;

    /**
     * @param string $valuePostfix
     * @return static
     */
    public function withValuePostfix(string $valuePostfix): static;
}
