<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsFloatOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 21:54:17
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsFloatOrNull;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\StandardTestValues;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsFloatOrNullTest extends ConstraintTestCase
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
        $validSamples = StandardTestValues::makeUnion(
            [null, PHP_INT_MIN - 1, PHP_INT_MAX + 1],
            StandardTestValues::get(StandardTestValues::FLOATS)
        );
        $testValues = new TestValues($validSamples, []);

        parent::__construct(new IsFloatOrNull(), $testValues, false, $name, $data, $dataName);
    }
}
