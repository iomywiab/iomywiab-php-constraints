<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsSigned64OrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:30:51
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsSigned64OrNull;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsSigned64OrNullTest extends ConstraintTestCase
{
    /**
     * @param mixed $name
     * @param array $data
     * @param mixed $dataName
     */
    public function __construct(
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        /** @noinspection PhpCastIsUnnecessaryInspection */
        /** @noinspection UnnecessaryCastingInspection */
        $testValues = new TestValues(
            [null, (int)-9223372036854775808, 0, 9223372036854775807, -1, 1],
            [(int)-9223372036854775808 - 1, 9223372036854775807 + 1]
        );

        parent::__construct(new IsSigned64OrNull(), $testValues, false, $name, $data, $dataName);
    }
}
