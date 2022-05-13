<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsUrlOrNull.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * @psalm-immutable
 */
class IsUrlOrNull extends IsUrl
{
    /**
     * @param mixed                  $value
     * @param array<int,string>|null $schemes
     * @param array<int,string>|null $hosts
     * @param array<int,int>|null    $ports
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @noinspection PhpTooManyParametersInspection
     */
    public static function isValid(
        mixed $value,
        ?array $schemes = null,
        ?array $hosts = null,
        ?array $ports = null,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if ((null === $value) || parent::isValid($value, $schemes, $hosts, $ports)) {
            return true;
        }

        if (null !== $errors) {
            if (false !== \filter_var($value, FILTER_VALIDATE_URL)) {
                self::addDetailErrors($value, $schemes, $hosts, $ports, $valueName, $errors);
            } else {
                $errors[] = self::toErrorMessage($value, $valueName, 'URL or null expected');
            }
        }

        return false;
    }
}
