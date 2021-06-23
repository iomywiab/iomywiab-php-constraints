<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInArrayOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsInArrayOrNull.php
 * Class name...: IsInArrayOrNull.php
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
 * File name....: IsInArrayOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsInArrayOrNull.php
 * Class name...: IsInArrayOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class Enum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsInArrayOrNull extends IsInArray
{

    /**
     * @inheritDoc
     */
    public static function isValid(
        array $array,
        $value,
        ?string $valueName = null,
        bool $strict = self::DEFAULT_STRICT,
        array &$errors = null
    ): bool {
        if ((null === $value) || parent::isValid($array, $value, $valueName, $strict)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Member of array [%s] or null expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toValueList($array));
        }
        return false;
    }

}