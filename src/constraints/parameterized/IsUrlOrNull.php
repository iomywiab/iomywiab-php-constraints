<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsUrlOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsUrlOrNull.php
 * Class name...: IsUrlOrNull.php
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
 * File name....: IsUrlOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsUrlOrNull.php
 * Class name...: IsUrlOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:36
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * Class Url
 * @package iomywiab\iomywiab_php_constraints
 */
class IsUrlOrNull extends IsUrl
{
    /**
     * @param               $value
     * @param string|null   $valueName
     * @param string[]|null $schemes
     * @param string[]|null $hosts
     * @param int[]|null    $ports
     * @param array|null    $errors
     * @return bool
     * @noinspection PhpTooManyParametersInspection
     */
    public static function isValid(
        $value,
        ?string $valueName = null,
        ?array $schemes = null,
        ?array $hosts = null,
        ?array $ports = null,
        array &$errors = null
    ): bool {
        if ((null === $value) || parent::isValid($value, $valueName, $schemes, $hosts, $ports)) {
            return true;
        }

        if (null !== $errors) {
            if (false === filter_var($value, FILTER_VALIDATE_URL)) {
                $errors[] = self::toErrorMessage($value, $valueName, 'URL or null expected');
            } else {
                self::addDetailErrors($value, $valueName, $schemes, $hosts, $ports, $errors);
            }
        }

        return false;
    }
}