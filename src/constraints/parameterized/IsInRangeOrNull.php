<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInRangeOrNull.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * @psalm-immutable
 */
class IsInRangeOrNull extends IsInRange
{
    /**
     * @inheritDoc
     */
    public static function isValid(
        float|int $minimum,
        float|int $maximum,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if ((null === $value) || parent::isValid($minimum, $maximum, $value)) {
            return true;
        }

        if (null !== $errors) {
            $minType = \is_int($minimum) ? 'd' : 'f';
            $maxType = \is_int($maximum) ? 'd' : 'f';
            $format = 'Numeric value (float|int|numerical string) in range [%'
                . $minType . ',%' . $maxType . '] or null expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $minimum, $maximum);
        }
        return false;
    }
}
