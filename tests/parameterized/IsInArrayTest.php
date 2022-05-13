<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInArrayTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:31:15
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsInArray;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsInArrayTest extends ConstraintTestCase
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
        $validSamples = [1, true, 'a', 'b', 'c', [1, 2]];
        $testValues = new TestValues($validSamples, ['d', 5]);

        parent::__construct(
            new IsInArray(['a', 'b', 'c', 1, true, [1, 2]]),
            $testValues,
            false,
            $name,
            $data,
            $dataName
        );
    }
}
