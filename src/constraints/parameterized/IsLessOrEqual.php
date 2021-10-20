<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsLessOrEqual.php
 * Class name...: IsLessOrEqual.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsNumeric;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Class maximum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsLessOrEqual extends IsLess
{
    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     * @throws ConstraintViolationException
     */
    public static function isValid($maximum, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsNumeric::assert($maximum);

        if (is_numeric($value) && ($value <= $maximum)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Numeric value smaller than or equal to maximum [%'
                . (is_int($maximum) ? 'd' : 'f') . '] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $maximum);
        }
        return false;
    }
}