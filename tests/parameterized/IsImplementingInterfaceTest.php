<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsImplementingInterfaceTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:31:30
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsGreater;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsImplementingInterface;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotEmpty;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotNull;
use iomywiab\iomywiab_php_constraints\interfaces\SimpleConstraintInterface;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsImplementingInterfaceTest extends ConstraintTestCase
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
        $validSamples = [new IsNotNull(), [new IsNotEmpty(), new IsNotNull()]];
        $testValues = new TestValues($validSamples, [new IsGreater(2)]);

        parent::__construct(
            new IsImplementingInterface(SimpleConstraintInterface::class),
            $testValues,
            false,
            $name,
            $data,
            $dataName
        );
    }
}
