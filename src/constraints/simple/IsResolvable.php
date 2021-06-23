<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsResolvable.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsResolvable.php
 * Class name...: IsResolvable.php
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
 * File name....: IsResolvable.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsResolvable.php
 * Class name...: IsResolvable.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 16:49:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;


/**
 * Class Resolvable
 * @package iomywiab\iomywiab_php_constraints
 */
class IsResolvable extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if (is_int($value)) {
            $value = long2ip($value);
        }

        if (is_string($value) && !empty($value)) {
            /** @noinspection SpellCheckingInspection */
            putenv('RES_OPTIONS=retrans:1 retry:1 timeout:1 attempts:1');
            $isIP = IsIpv4Address::isValid($value) || IsIpv6Address::isValid($value);
            $address = $isIP
                ? gethostbyaddr($value)
                : gethostbyname($value);

            if ((false !== $address) && ($value != $address)) {
                return true;
            }
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage(
                $value,
                $valueName,
                'Value is neither an IP address nor a resolvable DNS entry'
            );
        }
        return false;
    }
}