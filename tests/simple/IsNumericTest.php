<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsNumericTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 21:54:27
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsNumeric;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\StandardTestValues;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsNumericTest extends ConstraintTestCase
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
        $validSamples = StandardTestValues::makeUnion(
            [
                '-9223372036854775808',
                '-1',
                '0',
                '1',
                '9223372036854775807',
                '-1.7976931348623e+308',
                '-2.3',
                '-1.0',
                '0.0',
                '1.0',
                '2.3',
                '123456789.123456789',
                '1.7976931348623e+308'
            ],
            StandardTestValues::get(StandardTestValues::INTEGERS | StandardTestValues::FLOATS)
        );
        $testValues = new TestValues($validSamples, []);

        parent::__construct(new IsNumeric(), $testValues, false, $name, $data, $dataName);
    }
}
