<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsNotEqual.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * @psalm-immutable
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
        mixed $expected,
        mixed $actual,
        bool $strict = null,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        $strict = $strict ?? self::DEFAULT_STRICT;

        if ($strict && ($expected !== $actual)) {
            return true;
        }

        /** @noinspection TypeUnsafeComparisonInspection */
        if (!$strict && ($expected != $actual)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Expected value [%s] is not not equal to actual';
            $errors[] = self::toErrorMessage($actual, $valueName, $format, $expected);
        }
        return false;
    }
}
