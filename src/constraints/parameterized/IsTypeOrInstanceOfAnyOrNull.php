<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOrInstanceOfAnyOrNull.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsTypeOrInstanceOfAnyOrNull extends IsTypeOrInstanceOfAny
{
    /**
     * @param array<int,string>      $types
     * @param array<int,string>      $classesAndInterfaces
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        array $types,
        array $classesAndInterfaces,
        mixed $value,
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
