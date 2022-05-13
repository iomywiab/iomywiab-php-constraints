<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringArrayTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 21:52:17
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringArray;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsStringArrayTest extends ConstraintTestCase
{
    /**
     * @param mixed       $name
     * @param array       $data
     * @param mixed $dataName
     */
    public function __construct(
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        $validSamples = [
            [],
            ['a', 'b'],
            [''],
            ['abc'],
            ['null'],
            ['true'],
            ['false'],
            ['-9223372036854775808'], // PHP_INT_MIN
            ['-1'],
            ['0'],
            ['1'],
            ['9223372036854775807'], // PHP_INT_MAX
            ['-1.7976931348623e+308'], // -PHP_FLOAT_MAX
            ['-2.3'],
            ['-1.0'],
            ['0.0'],
            ['1.0'],
            ['2.3'],
            ['123456789.123456789'],
            ['1.7976931348623e+308'], // PHP_FLOAT_MAX
            ['This ia a long string with some repetitions. This ia a long string with some repetitions. ']
        ];
        $testValues = new TestValues($validSamples, [['a', 2], [1, 2]]);

        parent::__construct(new IsStringArray(), $testValues, false, $name, $data, $dataName);
    }
}
