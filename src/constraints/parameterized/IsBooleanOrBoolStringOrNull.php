<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBooleanOrBoolStringOrNull.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsBooleanOrBoolStringOrNull extends IsBoolString
{
    /**
     * @param mixed                   $value
     * @param array<string,bool>|null $lowercaseStrings
     * @param string|null             $valueName
     * @param array<int,string>|null  $errors
     * @return bool
     */
    public static function isValid(
        mixed $value,
        ?array $lowercaseStrings = null,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if ((null === $value) || \is_bool($value) || parent::isValid($value, $lowercaseStrings)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Boolean string or boolean or null expected. Valid string values=[%s]';
            $errors[] = self::toErrorMessage(
                $value,
                $valueName,
                $format,
                Format::toValueList(array_keys($lowercaseStrings ?? self::DEFAULT_BOOLEAN_STRINGS))
            );
        }
        return false;
    }
}
