<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsCallableOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:31:46
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsCallableOrNull;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsCallableOrNullTest extends ConstraintTestCase
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
        $testValues = new TestValues([null, [$this, 'callMe']], [[$this, 'callMeNot']]);

        parent::__construct(new IsCallableOrNull(), $testValues, false, $name, $data, $dataName);
    }

    /**
     * @return void
     */
    public function callMe(): void
    {
        echo 'test: pls ignore';
    }
}
