<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsResourceOrNull.php
 * Class name...: IsResourceOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * Class Numeric
 * @package iomywiab\iomywiab_php_constraints
 */
class IsResourceOrNull extends IsResource
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, ?string $type = null, array &$errors = null): bool
    {
        if ((null === $value) || parent::isValid($value, $valueName, $type)) {
            return true;
        }

        if (null !== $errors) {
            $expected = empty($type) ? 'any' : $type;
            $actual = is_resource($value) ? get_resource_type($value) : 'none';
            $format = 'Resource of type [%s] or null expected. Got resource type [%s]';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $expected, $actual);
        }
        return false;
    }

}