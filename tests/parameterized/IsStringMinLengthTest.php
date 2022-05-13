<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringMinLengthTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:00:14
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMinLength;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsStringMinLengthTest extends ConstraintTestCase
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
        $constraint = new IsStringMinLength(3);
        $validSamples = [
            '123',
            'abc',
            'true',
            'false',
            'null',
            '-2.3',
            '-1.0',
            '0.0',
            '1.0',
            '2.3',
            '-9223372036854775808',
            '9223372036854775807',
            '-1.7976931348623e+308',
            '123456789.123456789',
            '1.7976931348623e+308',
            'This ia a long string with some repetitions. This ia a long string with some repetitions. '
        ];
        $invalidSamples = ['12'];

        $testValues = new TestValues($validSamples, $invalidSamples);
        parent::__construct($constraint, $testValues, false, $name, $data, $dataName);
    }
}
