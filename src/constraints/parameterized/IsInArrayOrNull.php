<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInArrayOrNull.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsInArrayOrNull extends IsInArray
{
    /**
     * @inheritDoc
     */
    public static function isValid(
        array $array,
        mixed $value,
        ?bool $strict = null,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if ((null === $value) || parent::isValid($array, $value, $strict, $valueName)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Member of array [%s] or null expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toValueList($array));
        }
        return false;
    }
}
