<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractConstraint.php
 * Class name...: AbstractConstraint.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:32
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints;

use iomywiab\iomywiab_php_constraints\interfaces\ConstraintInterface;

/**
 * Class AbstractConstraint
 * @package iomywiab\iomywiab_php_constraints
 */
abstract class AbstractConstraint implements ConstraintInterface
{

    /**
     * @param             $value
     * @param string|null $valueName
     * @param string      $format use by vsprintf()
     * @return string
     * @see Format::toErrorMessage()
     * @noinspection SpellCheckingInspection
     */
    protected static function toErrorMessage($value, ?string $valueName, string $format): string
    {
        $num = func_num_args();
        if (3 < $num) {
            $arguments = func_get_args();
            unset($arguments[2]); // format
            unset($arguments[1]); // valueName
            unset($arguments[0]); // value
            $format = vsprintf($format, $arguments);
        }
        return (empty($valueName) ? '' : $valueName . ': ')
            . $format
            . '. Got ' . Format::toDescription($value);
    }

}