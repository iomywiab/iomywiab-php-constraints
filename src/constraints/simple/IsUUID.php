<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsUUID.php
 * Class name...: IsUUID.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * Class Minimum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsUUID extends AbstractSimpleConstraint
{
    public const REGEX = '/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/';
    public const ZERO_UUID = '00000000-0000-0000-0000-000000000000';

    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if (is_string($value)
            && ((self::ZERO_UUID == $value)
                || (1 == preg_match(self::REGEX, str_replace(['urn:', 'uuid:', '{', '}'], '', $value))))) {
            return true;
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage($value, $valueName, 'UUID expected');
        }
        return false;
    }
}