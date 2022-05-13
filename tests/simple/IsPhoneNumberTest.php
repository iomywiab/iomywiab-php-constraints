<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsPhoneNumberTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 21:49:31
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsPhoneNumber;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsPhoneNumberTest extends ConstraintTestCase
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
            0,
            1,
            1234567890,
            10,
            PHP_INT_MAX,
            '+49 12 1234567890',
            '+49 12 123 456 7890',
            '+49 (12) 123 456 7890',
            '+49 12 123 456-7890',
            '+49 12 123   456 7890',
            '+49 (12) 123   456-7890',
            '+49 (12) 123   456/7890',
            '9223372036854775807' // PHP_INT_MAX
        ];
        $testValues = new TestValues($validSamples, ['+49-12-123+456-7890']);

        parent::__construct(new IsPhoneNumber(), $testValues, false, $name, $data, $dataName);
    }
}
