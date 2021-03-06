<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsResolvable.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * @psalm-immutable
 */
class IsResolvable extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        if (\is_int($value)) {
            if (0 === $value) {
                return true; // 0 is the int expression for 0.0.0.0, which is a valid but unusable IP address
            }
            $value = \long2ip($value);
        }

        if (\is_string($value) && ('' !== $value)) {
            if ('0.0.0.0' === $value) {
                return true; // 0.0.0.0 is a valid but unusable IP address
            }

            /** @noinspection SpellCheckingInspection */
            \putenv('RES_OPTIONS=retrans:1 retry:1 timeout:1 attempts:1');
            $isIP = IsIpv4Address::isValid($value) || IsIpv6Address::isValid($value);
            if ($isIP) {
                $address = \gethostbyaddr($value);
            } else {
                $address = \is_numeric($value) ? false : \gethostbyname($value);
            }

            if ((false !== $address) && ($value !== $address)) {
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
