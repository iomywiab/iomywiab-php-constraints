<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsStringOrNull.php
 * Class name...: IsStringOrNull.php
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
 * File name....: IsStringOrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsStringOrNull.php
 * Class name...: IsStringOrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:36
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * Class IsNullOrString
 * @package iomywiab\iomywiab_php_constraints
 */
class IsStringOrNull extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if ((null === $value) || is_string($value)) {
            return true;
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage($value, $valueName, 'String or null expected');
        }
        return false;
    }

}