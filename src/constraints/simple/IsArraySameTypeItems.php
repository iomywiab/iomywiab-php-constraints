<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsArraySameTypeItems.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsArraySameTypeItems extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        if (\is_array($value)) {
            $isHomogeneous = true;
            $firstType = null;
            foreach ($value as $item) {
                if (null === $firstType) {
                    $firstType = Format::toType($item);
                } else {
                    $type = Format::toType($item);
                    if ($type !== $firstType) {
                        $isHomogeneous = false;
                        break;
                    }
                }
            }
            if ($isHomogeneous) {
                return true;
            }
        }

        if (null !== $errors) {
            if (\is_array($value)) {
                $firstType = null;
                $firstItem = null;
                $firstKey = null;
                foreach ($value as $key => $item) {
                    if (null === $firstType) {
                        $firstType = Format::toType($item);
                        $firstItem = $item;
                        $firstKey = $key;
                    } else {
                        $type = Format::toType($item);
                        if ($type !== $firstType) {
                            $errors[] = 'Homogeneous array expected. Got subarray ' . Format::toString(
                                [
                                        $firstKey => $firstItem,
                                        $key => $item
                                    ]
                            );
                        }
                    }
                }
            } else {
                $errors[] = self::toErrorMessage($value, $valueName, 'Array expected');
            }
        }
        return false;
    }
}
