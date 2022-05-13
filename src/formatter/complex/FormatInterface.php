<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: FormatInterface.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\complex;

/**+
 * @psalm-immutable
 */
interface FormatInterface
{
    /**
     * @param object|class-string $value
     * @return string
     * @throws \ReflectionException
     */
    public static function toClassName(object|string $value): string;

    /**
     * @param mixed $value
     * @param int   $maxLength
     * @return string
     */
    public static function toDebugString(mixed $value, int $maxLength = 0): string;

    /**
     * @param string     $message
     * @param array|null $values
     * @return string
     */
    public static function toMessage(string $message, ?array $values = null): string;

    /**
     * @param object|class-string $value
     * @return string
     * @throws \ReflectionException
     */
    public static function toShortClassName(object|string $value): string;

    /**
     * @param mixed $value
     * @param int   $maxLength
     * @return string
     */
    public static function toString(mixed $value, int $maxLength = 0): string;

    /**
     * @param mixed $value
     * @return string
     */
    public static function toType(mixed $value): string;

    /**
     * @param array $values
     * @param int   $maxLength
     * @return string
     */
    public static function toValueList(array $values, int $maxLength = 0): string;
}
