<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsEmailAddressOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsEmailAddressOrNull.php
 * Class name...: IsEmailAddressOrNull.php
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
 * File name....: IsEmailAddressOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsEmailAddressOrNull.php
 * Class name...: IsEmailAddressOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;


/**
 * Class Url
 * @package iomywiab\iomywiab_php_constraints
 */
class IsEmailAddressOrNull extends IsEmailAddress
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if ((null === $value) || parent::isValid($value)) {
            return true;
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage($value, $valueName, 'E-Mail address or null expected');
        }
        return false;
    }

}