<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsAOf.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsAOf.php
 * Class name...: IsAOf.php
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
 * File name....: IsAOf.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsAOf.php
 * Class name...: IsAOf.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:36
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringNotEmpty;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Class IsAOf
 * @package iomywiab\iomywiab_php_constraints
 */
class IsAOf extends AbstractClassnameConstraint
{
    /**
     * @param string      $className
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(string $className, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsStringNotEmpty::assert($className);

        if (is_a($value, $className, is_string($value))) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Instance of [%s] or its parents expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $className);
        }
        return false;
    }

}