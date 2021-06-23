<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringNotEmpty.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsStringNotEmpty.php
 * Class name...: IsStringNotEmpty.php
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
 * File name....: IsStringNotEmpty.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsStringNotEmpty.php
 * Class name...: IsStringNotEmpty.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * Class IsStringNotEmpty
 * @package iomywiab\iomywiab_php_constraints
 */
class IsStringNotEmpty extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if (is_string($value) && ('' !== $value)) {
            return true;
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage($value, $valueName, 'Non empty string expected');
        }
        return false;
    }
}