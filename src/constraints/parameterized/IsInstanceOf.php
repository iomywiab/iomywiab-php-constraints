<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInstanceOf.php
 * Class name...: IsInstanceOf.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * Class Instance
 * @package iomywiab\iomywiab_php_constraints
 */
class IsInstanceOf extends AbstractClassnameConstraint
{
    /**
     * @param string      $className
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid(string $className, $value, ?string $valueName = null, array &$errors = null): bool
    {
        if ($value instanceof $className) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Instance of [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $className);
        }
        return false;
    }

}