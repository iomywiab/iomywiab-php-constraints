<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsEmailAddressTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:32:02
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsEmailAddress;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsEmailAddressTest extends ConstraintTestCase
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
        $testValues = new TestValues(
            ['a@bc.de', 'user@github.com', 'firstname.lastname@github.com'],
            ['//github.com', '@github.com', 'user', 'firstname.lastname', 'user@', 'firstname.lastname@']
        );

        parent::__construct(new IsEmailAddress(), $testValues, false, $name, $data, $dataName);
    }
}
