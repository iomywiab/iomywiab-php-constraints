<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringEndingWithOrNull.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * @psalm-immutable
 */
class IsStringEndingWithOrNull extends IsStringEndingWith
{
    /**
     * @param string $endString
     * @param mixed $value
     * @param string|null $valueName
     * @param array<int,string>|null $errors
     * @return bool
     */
    public static function isValid(
        string $endString,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if ((null === $value) || parent::isValid($endString, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'String ending with [%s] or null expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $endString);
        }
        return false;
    }
}
