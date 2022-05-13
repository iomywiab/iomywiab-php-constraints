<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsUUIDTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:30:48
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsUUID;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsUUIDTest extends ConstraintTestCase
{
    /**
     * @param mixed $name
     * @param array $data
     * @param mixed $dataName
     * @noinspection SpellCheckingInspection
     */
    public function __construct(
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        $testValues = new TestValues(
            ['00000000-0000-0000-0000-000000000000', '550e8400-e29b-11d4-a716-446655440000'],
            ['550e8400-WXYZ-11d4-a716-446655440000']
        );

        parent::__construct(new IsUUID(), $testValues, false, $name, $data, $dataName);
    }
}
