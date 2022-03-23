<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsArrayUniqueValues.php
 * Class name...: IsArrayUniqueValues.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class Unique
 * @package iomywiab\iomywiab_php_constraints
 */
class IsArrayUniqueValues extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        if (!\is_array($value)) {
            return true;
        }

        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        $all = \count($value);
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        $unique = \count(\array_unique($value));

        if ($all == $unique) {
            return true;
        }

        if (null !== $errors) {
            $counts = [];
            foreach ($value as $item) {
                /** @noinspection PhpFullyQualifiedNameUsageInspection */
                if (\array_key_exists($item, $counts)) {
                    $counts[$item]++;
                } else {
                    $counts[$item] = 1;
                }
            }
            foreach ($counts as $value => $count) {
                if (1 < $count) {
                    $format = 'Unique values expected. Duplicates found: %dx [%s]';
                    $errors[] = self::toErrorMessage($value, $valueName, $format, $count, Format::toString($value));
                }
            }
        }
        return false;
    }

}