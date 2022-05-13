<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsArrayKeyOrNull.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

/** @noinspection LongInheritanceChainInspection */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * @psalm-immutable
 */
class IsArrayKeyOrNull extends IsArrayKey
{
    /**
     * @inheritDoc
     */
    public static function isValid(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        if ((null === $value) || parent::isValid($value)) {
            return true;
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage($value, $valueName, 'Array key [integer|string] or null expected');
        }
        return false;
    }
}