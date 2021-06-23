<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsSigned64.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsSigned64.php
 * Class name...: IsSigned64.php
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
 * File name....: IsSigned64.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsSigned64.php
 * Class name...: IsSigned64.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * Class Unsigned64
 * @package iomywiab\iomywiab_php_constraints
 */
class IsSigned64 extends IsInteger
{
    public const MIN = -9223372036854775808;
    public const MAX = 9223372036854775807;
}