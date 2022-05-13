<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInteger.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * @psalm-immutable
 */
class IsInteger extends AbstractSimpleConstraint
{
    public const MIN = PHP_INT_MIN;
    public const MAX = PHP_INT_MAX;

    /**
     * @inheritDoc
     */
    public static function isValid(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        $isValid = false;
        if (\is_numeric($value)) {
            $mustBeInt = ((PHP_INT_MIN <= $value) && ($value <= PHP_INT_MAX));
            $isValid = ($mustBeInt ? \is_int($value) : \is_float($value))
                && (static::MIN <= $value) && ($value <= static::MAX);
        }

        if (!$isValid && (null !== $errors)) {
            $format = 'Integer in range [%d,%d] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, static::MIN, static::MAX);
        }
        return $isValid;
    }
}
