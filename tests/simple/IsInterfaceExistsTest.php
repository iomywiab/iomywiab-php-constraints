<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInterfaceExistsTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:31:47
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsInterfaceExists;
use iomywiab\iomywiab_php_constraints\interfaces\ConstraintContainerInterface;
use iomywiab\iomywiab_php_constraints\interfaces\ConstraintInterface;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsInterfaceExistsTest extends ConstraintTestCase
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
            [ConstraintInterface::class, ConstraintContainerInterface::class],
            [ConstraintInterface::class . 'XXX']
        );

        parent::__construct(new IsInterfaceExists(), $testValues, false, $name, $data, $dataName);
    }
}
