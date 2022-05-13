<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsResourceOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:31:36
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsResourceOrNull;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\StandardTestValues;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsResourceOrNullTest extends ConstraintTestCase
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
        $stdout = fopen('php://stdout', 'wb');
        $constraint = new IsResourceOrNull('stream');
        $validSamples = [$stdout, null];
        $invalidSamples = [StandardTestValues::getException()];

        $testValues = new TestValues($validSamples, $invalidSamples);
        parent::__construct($constraint, $testValues, false, $name, $data, $dataName);
    }
//    /**
//     * @throws ExpectationFailedException
//     * @throws InvalidArgumentException
//     * @throws ConstraintViolationException
//     */
//    public function testIsValid(): void
//    {
//
//        $this->checkConstraint(
//            new IsResourceOrNull(),
//            [$stdout, null],
//            [self::$testException]
//        );
//        $this->checkConstraint(
//            new IsResourceOrNull('stream'),
//            [$stdout, null],
//            [self::$testException]
//        );
//    }
//
//    /**
//     * @throws ConstraintViolationException
//     * @throws Exception
//     */
//    public function testAssert(): void
//    {
//        self::expectException(ConstraintViolationException::class);
//        $stdout = fopen('php://stdout', 'w');
//        try {
//            IsResourceOrNull::assert(null);
//            IsResourceOrNull::assert($stdout);
//            IsResourceOrNull::assert($stdout, null, 'stream');
//        } catch (Exception $cause) {
//            throw new Exception('Unexpected exception', 0, $cause);
//        }
//        IsResourceOrNull::assert('x');
//    }
}
