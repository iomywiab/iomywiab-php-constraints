<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsIpv4Address.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsIpv4Address.php
 * Class name...: IsIpv4Address.php
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
 * File name....: IsIpv4Address.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsIpv4Address.php
 * Class name...: IsIpv4Address.php
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
class IsIpv4Address extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if (false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return true;
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage($value, $valueName, 'IP v4 address expected');
        }
        return false;
    }

}