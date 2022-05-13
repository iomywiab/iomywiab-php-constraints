<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractConstraint.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:43
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints;

use iomywiab\iomywiab_php_constraints\formatter\complex\Format;
use iomywiab\iomywiab_php_constraints\interfaces\ConstraintInterface;

/**
 * @psalm-immutable
 */
abstract class AbstractConstraint implements ConstraintInterface
{
    /**
     * @param mixed       $value
     * @param string|null $valueName
     * @param string      $format used by vsprintf()
     * @return string
     * @see Format::toDebugString()
     * @noinspection SpellCheckingInspection
     */
    protected static function toErrorMessage(mixed $value, ?string $valueName, string $format): string
    {
        $num = \func_num_args();
        if (3 < $num) {
            $arguments = \func_get_args();
            unset($arguments[2], $arguments[1], $arguments[0]); // format, valueName, value
            $format = \vsprintf($format, $arguments);
        }
        return (null === $valueName || '' === $valueName ? '' : $valueName . ': ')
            . $format
            . '. Got ' . Format::toDebugString($value);
    }

    /**
     * Even though this method actually does nothing it is required to avoid PHP 8 error warnings.
     * @return array
     */
    public function __serialize(): array
    {
        return [];
    }

    /**
     * Even though this method actually does nothing it is required to avoid PHP 8 error warnings.
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        // no code
    }
}
