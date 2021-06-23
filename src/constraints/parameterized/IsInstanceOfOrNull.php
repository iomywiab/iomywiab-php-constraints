<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInstanceOfOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsInstanceOfOrNull.php
 * Class name...: IsInstanceOfOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:30
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInstanceOfOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsInstanceOfOrNull.php
 * Class name...: IsInstanceOfOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:36
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * Class Instance
 * @package iomywiab\iomywiab_php_constraints
 */
class IsInstanceOfOrNull extends IsInstanceOf
{
    /**
     * @inheritDoc
     */
    public static function isValid(string $className, $value, ?string $valueName = null, array &$errors = null): bool
    {
        if ((null === $value) || parent::isValid($className, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Instance of [%s] or null expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $className);
        }
        return false;
    }

}