<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTrueTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 20:10:51
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsTrue;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsTrueTest extends ConstraintTestCase
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
        /** @noinspection PhpExpressionWithSameOperandsInspection */
        /** @noinspection SuspiciousBinaryOperationInspection */
        /** @noinspection TypeUnsafeComparisonInspection */
        $testValues = new TestValues(
            [true, (1 == 1), (1 === 1), (1 != 2), (1 !== 2)],
            [false, (1 != 1), (1 !== 1), (1 == 2), (1 === 2)]
        );

        parent::__construct(new IsTrue(), $testValues, false, $name, $data, $dataName);
    }
}
