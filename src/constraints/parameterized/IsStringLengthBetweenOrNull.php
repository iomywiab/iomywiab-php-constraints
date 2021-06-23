<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringLengthBetweenOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsStringLengthBetweenOrNull.php
 * Class name...: IsStringLengthBetweenOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:30
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringLengthBetweenOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsStringLengthBetweenOrNull.php
 * Class name...: IsStringLengthBetweenOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * Class StandardUnsigned
 * @package iomywiab\iomywiab_php_constraints
 */
class IsStringLengthBetweenOrNull extends IsStringLengthBetween
{
    /**
     * @inheritDoc
     */
    public static function isValid(
        int $minimum,
        int $maximum,
        $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if ((null === $value) || parent::isValid($minimum, $maximum, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'String of length [%d,%d] or null expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $minimum, $maximum);
        }

        return false;
    }

}