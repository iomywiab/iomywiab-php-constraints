<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInteger.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsInteger.php
 * Class name...: IsInteger.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:29
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInteger.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsInteger.php
 * Class name...: IsInteger.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;


/**
 * Class IsInteger
 * @package iomywiab\iomywiab_php_constraints
 */
class IsInteger extends AbstractSimpleConstraint
{
    public const MIN = PHP_INT_MIN;
    public const MAX = PHP_INT_MAX;

    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        $isValid = false;
        if (is_numeric($value)) {
            $mustBeInt = ((PHP_INT_MIN <= $value) && ($value <= PHP_INT_MAX));
            $isValid = ($mustBeInt ? is_int($value) : is_float($value))
                && (static::MIN <= $value) && ($value <= static::MAX);
        }

        if (!$isValid && (null !== $errors)) {
            $format = 'Integer in range [%d,%d] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, static::MIN, static::MAX);
        }
        return $isValid;
    }

}