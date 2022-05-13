<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsIntegerArray.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * @psalm-immutable
 */
class IsIntegerArray extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        if (\is_array($value)) {
            $isValid = true;
            foreach ($value as $item) {
                if (!\is_int($item)) {
                    $isValid = false;
                    break;
                }
            }
            if ($isValid) {
                return true;
            }
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage($value, $valueName, 'Integer array expected');
        }
        return false;
    }
}
