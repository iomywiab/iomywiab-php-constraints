<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsGreaterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 21:56:44
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsGreater;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsGreaterTest extends ConstraintTestCase
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
        $validSamples = [
            2.01,
            3,
            3.0,
            2.3,
            123456789.123456789,
            PHP_INT_MAX,
            PHP_FLOAT_MAX,
            '9223372036854775807',
            '2.3',
            '123456789.123456789',
            '1.7976931348623e+308',
        ];
        $testValues = new TestValues($validSamples, [1.99]);

        parent::__construct(new IsGreater(2), $testValues, false, $name, $data, $dataName);
    }
}
