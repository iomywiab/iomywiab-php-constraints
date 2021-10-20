<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOrInstanceOfAnyOrNull.php
 * Class name...: IsTypeOrInstanceOfAnyOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:32
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class IsTypeOrInstanceOfAnyOrNull
 * @package iomywiab\iomywiab_php_constraints\parameterized
 */
class IsTypeOrInstanceOfAnyOrNull extends IsTypeOrInstanceOfAny
{
    /**
     * @param array       $types
     * @param array       $classesAndInterfaces
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        array $types,
        array $classesAndInterfaces,
        $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if ((null === $value) || parent::isValid($types, $classesAndInterfaces, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Type [%s] or instance of [%s] or null expected';
            $typeList = Format::toValueList($types);
            $instanceList = Format::toValueList($classesAndInterfaces);
            $errors[] = self::toErrorMessage($value, $valueName, $format, $typeList, $instanceList);
        }
        return false;
    }

}