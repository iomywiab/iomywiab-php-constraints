<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsNullTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 21:02:41
 * Version......: v2
 */

/** @noinspection RedundantSuppression */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsNull;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\StandardTestValues;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsNullTest extends ConstraintTestCase
{
    /**
     * @param mixed       $name
     * @param array       $data
     * @param mixed $dataName
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function __construct(
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        $invalidSamples = StandardTestValues::get(StandardTestValues::ALL);
        $pos = \array_search(null, $invalidSamples, true);
        if (false !== $pos) {
            unset($invalidSamples[$pos]);
        }
        $testValues = new TestValues([null], []);

        parent::__construct(new IsNull(), $testValues, false, $name, $data, $dataName);
    }
}
