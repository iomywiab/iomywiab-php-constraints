<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringNotEmptyTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-06 14:17:32
 * Version......: v2
 */

/** @noinspection RedundantSuppression */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringNotEmpty;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\StandardTestValues;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsStringNotEmptyTest extends ConstraintTestCase
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
        $validSamples = StandardTestValues::get(StandardTestValues::STRINGS);
        $pos = \array_search('', $validSamples, true);
        if (false !== $pos) {
            unset($validSamples[$pos]);
        }
        $testValues = new TestValues($validSamples, []);

        parent::__construct(new IsStringNotEmpty(), $testValues, false, $name, $data, $dataName);
    }
}
