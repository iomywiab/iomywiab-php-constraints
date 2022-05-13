<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInstanceOfAnyOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:31:19
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Error;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsInstanceOfAnyOrNull;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\StandardTestValues;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;
use LogicException;
use RuntimeException;

/**
 */
class IsInstanceOfAnyOrNullTest extends ConstraintTestCase
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
        $validSamples = [new LogicException(), new RuntimeException(), null];
        $testValues = new TestValues($validSamples, [StandardTestValues::getException(), new Error()]);

        parent::__construct(
            new IsInstanceOfAnyOrNull([RuntimeException::class, LogicException::class]),
            $testValues,
            false,
            $name,
            $data,
            $dataName
        );
    }
}
