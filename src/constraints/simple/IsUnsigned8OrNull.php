<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsUnsigned8OrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsUnsigned8OrNull.php
 * Class name...: IsUnsigned8OrNull.php
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
 * File name....: IsUnsigned8OrNull.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/simple/IsUnsigned8OrNull.php
 * Class name...: IsUnsigned8OrNull.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * Class Unsigned8
 * @package iomywiab\iomywiab_php_constraints
 */
class IsUnsigned8OrNull extends IsIntegerOrNull
{
    public const MIN = 0;
    public const MAX = 255; // (2 ** 8) - 1;

}