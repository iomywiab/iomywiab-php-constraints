<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBooleanOrBoolStringOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsBooleanOrBoolStringOrNull.php
 * Class name...: IsBooleanOrBoolStringOrNull.php
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
 * File name....: IsBooleanOrBoolStringOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsBooleanOrBoolStringOrNull.php
 * Class name...: IsBooleanOrBoolStringOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class StandardBoolString
 * @package iomywiab\iomywiab_php_constraints
 */
class IsBooleanOrBoolStringOrNull extends IsBoolString
{
    /**
     * @param array       $lowercaseStrings
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid(
        $value,
        ?string $valueName = null,
        array $lowercaseStrings = self::DEFAULT_BOOLEAN_STRINGS,
        array &$errors = null
    ): bool {
        if ((null === $value) || is_bool($value) || parent::isValid($value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Boolean string or boolean or null expected. Valid string values=[%s]';
            $errors[] = self::toErrorMessage(
                $value,
                $valueName,
                $format,
                Format::toValueList(array_keys($lowercaseStrings))
            );
        }
        return false;
    }

}