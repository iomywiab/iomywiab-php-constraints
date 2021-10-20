<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOfAnyOrNull.php
 * Class name...: IsTypeOfAnyOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class Type
 * @package iomywiab\iomywiab_php_constraints
 */
class IsTypeOfAnyOrNull extends IsTypeOfAny
{
    /**
     * @param string[]    $types
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(array $types, $value, ?string $valueName = null, array &$errors = null): bool
    {
        if ((null === $value) || parent::isValid($types, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Type [%s] or null expected';
            $list = Format::toValueList($types);
            $errors[] = self::toErrorMessage($value, $valueName, $format, $list);
        }
        return false;
    }
}