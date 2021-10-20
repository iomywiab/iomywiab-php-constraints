<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsPhoneNumber.php
 * Class name...: IsPhoneNumber.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * Class PhoneNumber
 * @package iomywiab\iomywiab_php_constraints
 */
class IsPhoneNumber extends AbstractSimpleConstraint
{
    public const REGEX = '/^[+]?[0-9][0-9 \-()\/]{2,30}$/';

    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if ((is_int($value) && ($value >= 0)) || (is_string($value) && (1 == preg_match(self::REGEX, $value)))) {
            return true;
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage($value, $valueName, 'Phone number expected');
        }
        return false;
    }

}