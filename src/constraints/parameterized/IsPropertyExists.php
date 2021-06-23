<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsPropertyExists.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsPropertyExists.php
 * Class name...: IsPropertyExists.php
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
 * File name....: IsPropertyExists.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsPropertyExists.php
 * Class name...: IsPropertyExists.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsTrue;
use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class Enum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsPropertyExists extends AbstractObjectOrClassnameConstraint
{
    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public static function isValid($objectOrClass, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsTrue::assert(is_object($objectOrClass) || is_string($objectOrClass));

        if (is_string($value) && property_exists($objectOrClass, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Property of class [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toString($objectOrClass));
        }
        return false;
    }
}