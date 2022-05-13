<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOrInstanceOfAnyTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 21:54:05
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsTypeOrInstanceOfAny;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\StandardTestValues;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;
use LogicException;

/**
 */
class IsTypeOrInstanceOfAnyTest extends ConstraintTestCase
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
        $constraint = new IsTypeOrInstanceOfAny([IsType::INT, IsType::FLOAT], [LogicException::class]);
        $validSamples = [new LogicException()];
        $validSamples = StandardTestValues::makeUnion(
            $validSamples,
            StandardTestValues::get(StandardTestValues::FLOATS | StandardTestValues::INTEGERS)
        );
        $invalidSamples = ['x', true, false, [], StandardTestValues::getException()];

        $testValues = new TestValues($validSamples, $invalidSamples);
        parent::__construct($constraint, $testValues, false, $name, $data, $dataName);
    }
}
