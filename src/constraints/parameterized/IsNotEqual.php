<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsNotEqual.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsNotEqual.php
 * Class name...: IsNotEqual.php
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
 * File name....: IsNotEqual.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsNotEqual.php
 * Class name...: IsNotEqual.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:36
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * Class maximum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsNotEqual extends IsEqual
{
    /**
     * @param mixed       $expected
     * @param mixed       $actual
     * @param string|null $valueName
     * @param bool        $strict
     * @param array|null  $errors
     * @return bool
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public static function isValid(
        $expected,
        $actual,
        ?string $valueName = null,
        bool $strict = self::DEFAULT_STRICT,
        array &$errors = null
    ): bool {
        if ($strict && ($expected !== $actual)) {
            return true;
        } elseif (!$strict && ($expected != $actual)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Expected value [%s] is not not equal to actual';
            $errors[] = self::toErrorMessage($actual, $valueName, $format, $expected);
        }
        return false;
    }

}