<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringStartingWithOrNull.php
 * Class name...: IsStringStartingWithOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:32
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * Class Numeric
 * @package iomywiab\iomywiab_php_constraints
 */
class IsStringStartingWithOrNull extends IsStringStartingWith
{
    /**
     * @param string      $prefix
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid(string $prefix, $value, ?string $valueName = null, array &$errors = null): bool
    {
        if ((null === $value) || parent::isValid($prefix, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'String starting with [%s] or null expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $prefix);
        }
        return false;
    }

}