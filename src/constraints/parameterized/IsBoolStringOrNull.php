<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBoolStringOrNull.php
 * Class name...: IsBoolStringOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:32
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class StandardBoolString
 * @package iomywiab\iomywiab_php_constraints
 */
class IsBoolStringOrNull extends IsBoolString
{
    /**
     * @inheritDoc
     */
    public static function isValid(
        $value,
        ?string $valueName = null,
        array $lowercaseStrings = self::DEFAULT_BOOLEAN_STRINGS,
        array &$errors = null
    ): bool {
        if ((null === $value) || parent::isValid($value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Boolean string or null expected. Valid values=[%s]';
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