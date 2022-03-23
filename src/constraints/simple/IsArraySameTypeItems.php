<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsArraySameTypeItems.php
 * Class name...: IsArraySameTypeItems.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class IsArraySameTypeItems
 * @package iomywiab\iomywiab_php_constraints
 */
class IsArraySameTypeItems extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        if (\is_array($value)) {
            $isHomogeneous = true;
            $firstType = null;
            foreach ($value as $item) {
                if (empty($firstType)) {
                    $firstType = Format::toType($item);
                } else {
                    $type = Format::toType($item);
                    if ($type != $firstType) {
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
            /** @noinspection PhpFullyQualifiedNameUsageInspection */
            if (\is_array($value)) {
                $firstType = null;
                $firstItem = null;
                $firstKey = null;
                foreach ($value as $key => $item) {
                    if (empty($firstType)) {
                        $firstType = Format::toType($item);
                        $firstItem = $item;
                        $firstKey = $key;
                    } else {
                        $type = Format::toType($item);
                        if ($type != $firstType) {
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