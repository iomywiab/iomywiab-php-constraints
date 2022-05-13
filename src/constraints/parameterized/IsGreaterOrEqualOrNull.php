<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsGreaterOrEqualOrNull.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
 * Version......: v2
 */

/** @noinspection LongInheritanceChainInspection */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * @psalm-immutable
 */
class IsGreaterOrEqualOrNull extends IsGreaterOrEqual
{
    /**
     * @inheritDoc
     */
    public static function isValid(float|int $minimum, $value, ?string $valueName = null, array &$errors = null): bool
    {
        if ((null === $value) || parent::isValid($minimum, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Numeric value (float|int|string) larger than or equal to minimum [%'
                . (\is_int($minimum) ? 'd' : 'f') . '] or null expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $minimum);
        }
        return false;
    }
}
