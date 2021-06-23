<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInterfaceExists.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsInterfaceExists.php
 * Class name...: IsInterfaceExists.php
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
 * File name....: IsInterfaceExists.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsInterfaceExists.php
 * Class name...: IsInterfaceExists.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * Class Enum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsInterfaceExists extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if (is_string($value) && interface_exists($value)) {
            return true;
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage($value, $valueName, 'Interface not found');
        }
        return false;
    }
}