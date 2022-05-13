<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: TypeFormatterInterface.php
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
interface TypeFormatterInterface extends FormatterInterface
{
    /**
     * @param mixed $value
     * @return string
     */
    public function toString(mixed $value): string;

    /**
     * @return string
     */
    public function getArrayString(): string;

    /**
     * @return string
     */
    public function getBooleanString(): string;

    /**
     * @return string
     */
    public function getFloatString(): string;

    /**
     * @return string
     */
    public function getIntegerString(): string;

    /**
     * @return string
     */
    public function getNullString(): string;

    /**
     * @return string
     */
    public function getObjectString(): string;

    /**
     * @return string
     */
    public function getResourceString(): string;

    /**
     * @return string
     */
    public function getClosedResourceString(): string;

    /**
     * @return string
     */
    public function getStringString(): string;

    /**
     * @return string
     */
    public function getUnknownString(): string;

    /**
     * @param string $arrayString
     * @return static
     */
    public function withArrayString(string $arrayString): static;

    /**
     * @param string $booleanString
     * @return static
     */
    public function withBooleanString(string $booleanString): static;

    /**
     * @param string $floatString
     * @return static
     */
    public function withFloatString(string $floatString): static;

    /**
     * @param string $integerString
     * @return static
     */
    public function withIntegerString(string $integerString): static;

    /**
     * @param string $nullString
     * @return static
     */
    public function withNullString(string $nullString): static;

    /**
     * @param string $objectString
     * @return static
     */
    public function withObjectString(string $objectString): static;

    /**
     * @param string $resourceString
     * @return static
     */
    public function withResourceString(string $resourceString): static;

    /**
     * @param string $closedResourceString
     * @return static
     */
    public function withClosedResourceString(string $closedResourceString): static;

    /**
     * @param string $stringString
     * @return static
     */
    public function withStringString(string $stringString): static;

    /**
     * @param string $unknownString
     * @return static
     */
    public function withUnknownString(string $unknownString): static;

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
