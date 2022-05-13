<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsLessOrEqual.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * @psalm-immutable
 */
class IsLessOrEqual extends IsLess
{
    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     * @throws ConstraintViolationException
     */
    public static function isValid(
        float|int $maximum,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if (\is_numeric($value) && ($value <= $maximum)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Numeric value smaller than or equal to maximum [%'
                . (\is_int($maximum) ? 'd' : 'f') . '] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $maximum);
        }
        return false;
    }
}
