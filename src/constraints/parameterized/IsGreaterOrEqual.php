<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsGreaterOrEqual.php
 * Class name...: IsGreaterOrEqual.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsNumeric;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Class Maximum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsGreaterOrEqual extends IsGreater
{
    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     * @throws ConstraintViolationException
     */
    public static function isValid($minimum, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsNumeric::assert($minimum);

        if (is_numeric($value) && ($value >= $minimum)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Numeric value greater than or equal to minimum [%' . (is_int(
                    $minimum
                ) ? 'd' : 'f') . '] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $minimum);
        }
        return false;
    }
}