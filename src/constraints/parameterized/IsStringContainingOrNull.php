<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringContainingOrNull.php
 * Class name...: IsStringContainingOrNull.php
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
class IsStringContainingOrNull extends IsStringContaining
{

    /**
     * @param string      $subString
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid(string $subString, $value, ?string $valueName = null, array &$errors = null): bool
    {
        if ((null === $value) || parent::isValid($subString, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'String containing [%s] or null expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $subString);
        }
        return false;
    }

}