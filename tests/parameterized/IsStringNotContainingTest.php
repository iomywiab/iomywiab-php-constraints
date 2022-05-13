<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringNotContainingTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:00:52
 * Version......: v2
 */

/** @noinspection SpellCheckingInspection */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringNotContaining;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsStringNotContainingTest extends ConstraintTestCase
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
        $constraint = new IsStringNotContaining('e');
        $validSamples = [
            'abc',
            'xabc',
            'abcx',
            'xabcx',
            '',
            'null',
            '-1',
            '0',
            '1',
            '-2.3',
            '-1.0',
            '0.0',
            '1.0',
            '2.3',
            '-9223372036854775808',
            '9223372036854775807',
            '123456789.123456789',
        ];
        $invalidSamples = ['e', 'email', 'the', 'tea'];

        $testValues = new TestValues($validSamples, $invalidSamples);
        parent::__construct($constraint, $testValues, false, $name, $data, $dataName);
    }
}
