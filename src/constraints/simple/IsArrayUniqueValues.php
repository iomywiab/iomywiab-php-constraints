<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsArrayUniqueValues.php
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
class IsArrayUniqueValues extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        if (!\is_array($value)) {
            return false;
        }

        $all = \count($value);
        $unique = \count(\array_unique($value));

        if ($all === $unique) {
            return true;
        }

        if (null !== $errors) {
            $counts = [];
            foreach ($value as $item) {
                if (\array_key_exists($item, $counts)) {
                    $counts[$item]++;
                } else {
                    $counts[$item] = 1;
                }
            }
            foreach ($counts as $countName => $count) {
                if (1 < $count) {
                    $format = 'Unique values expected. Duplicates found: %dx [%s]';
                    $errors[] = self::toErrorMessage(
                        $value,
                        $valueName,
                        $format,
                        $count,
                        Format::toString($countName)
                    );
                }
            }
        }
        return false;
    }
}
