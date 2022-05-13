<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBoolStringTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 20:21:34
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsBoolString;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsBoolStringTest extends ConstraintTestCase
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
            'true',
            'false',
            '1',
            '0',
            'on',
            'off',
            'yes',
            'no',
            'y',
            'n',
            'enabled',
            'disabled',
            'activated',
            'deactivated',
            'active',
            'inactive'
        ];
        $testValues = new TestValues($validSamples, ['TRUE', 'FALSE']);

        parent::__construct(new IsBoolString(), $testValues, false, $name, $data, $dataName);
    }
}
