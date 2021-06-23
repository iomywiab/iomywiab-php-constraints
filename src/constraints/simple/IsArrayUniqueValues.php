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
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsArrayUniqueValues.php
 * Class name...: IsArrayUniqueValues.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:29
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsArrayUniqueValues.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsArrayUniqueValues.php
 * Class name...: IsArrayUniqueValues.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
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
    // TODO implement strict
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if (!is_array($value)) {
            return true;
        }

        $all = count($value);
        $unique = count(array_unique($value));

        if ($all == $unique) {
            return true;
        }

        if (null !== $errors) {
            $counts = [];
            foreach ($value as $item) {
                if (array_key_exists($item, $counts)) {
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