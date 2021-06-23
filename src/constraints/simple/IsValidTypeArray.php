<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsValidTypeArray.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsValidTypeArray.php
 * Class name...: IsValidTypeArray.php
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
 * File name....: IsValidTypeArray.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsValidTypeArray.php
 * Class name...: IsValidTypeArray.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:36
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class IsValidType
 * @package iomywiab\iomywiab_php_constraints\simple
 */
class IsValidTypeArray extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if (is_array($value) && !empty($value)) {
            $isOk = true;
            foreach ($value as $item) {
                if (!IsValidType::isValid($item)) {
                    $isOk = false;
                }
            }
            if ($isOk) {
                return true;
            }
        }

        if (null !== $errors) {
            $list = Format::toValueList(IsValidType::ALL_TYPES);
            $errors[] = self::toErrorMessage($value, $valueName, 'Type name [%s] expected', $list);
        }
        return false;
    }
}