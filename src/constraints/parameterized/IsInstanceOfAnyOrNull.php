<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInstanceOfAnyOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsInstanceOfAnyOrNull.php
 * Class name...: IsInstanceOfAnyOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:29
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInstanceOfAnyOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsInstanceOfAnyOrNull.php
 * Class name...: IsInstanceOfAnyOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class Instance
 * @package iomywiab\iomywiab_php_constraints
 */
class IsInstanceOfAnyOrNull extends IsInstanceOfAny
{
    /**
     * @inheritDoc
     */
    public static function isValid(
        array $classesAndInterfaces,
        $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if ((null === $value) || parent::isValid($classesAndInterfaces, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Instance of [%s] or null expected';
            $list = Format::toValueList($classesAndInterfaces);
            $errors[] = self::toErrorMessage($value, $valueName, $format, $list);
        }
        return false;
    }

}