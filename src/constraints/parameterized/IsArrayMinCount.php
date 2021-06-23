<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsArrayMinCount.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsArrayMinCount.php
 * Class name...: IsArrayMinCount.php
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
 * File name....: IsArrayMinCount.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsArrayMinCount.php
 * Class name...: IsArrayMinCount.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:36
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * Class Minimum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsArrayMinCount extends AbstractMinimumIntConstraint
{
    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public static function isValid(int $minimum, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsGreaterOrEqual::assert(0, $minimum);

        if (is_array($value) && ($minimum <= count($value))) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Array with a minimum number of items [%d] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $minimum);
        }
        return false;
    }
}