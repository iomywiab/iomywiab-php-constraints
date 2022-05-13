<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsEqualTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:31:23
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsEqual;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsEqualTest extends ConstraintTestCase
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
        $testValues = new TestValues(['hello'], ['world']);

        parent::__construct(new IsEqual('hello'), $testValues, false, $name, $data, $dataName);
    }

//    /**
//     * @throws ExpectationFailedException
//     * @throws InvalidArgumentException
//     * @throws ConstraintViolationException
//     */
//    public function testIsValid(): void
//    {
//        $this->checkConstraint(
//            new IsEqual('hello'),
//            ['hello'],
//            ['world']
//        );
//        if (8 > PHP_MAJOR_VERSION) {
//            $this->checkConstraint(
//                new IsEqual('hello', false),
//                ['hello', true, 0, 0.0],
//                ['world']
//            );
//        } else {
//            $this->checkConstraint(
//                new IsEqual('hello', false),
//                ['hello', true],
//                ['world']
//            );
//        }
//    }
//
//    /**
//     * @throws ConstraintViolationException
//     * @throws Exception
//     */
//    public function testAssert(): void
//    {
//        self::expectException(ConstraintViolationException::class);
//        try {
//            IsEqual::assert('hello', 'hello');
//        } catch (Exception $cause) {
//            throw new Exception('Unexpected exception', 0, $cause);
//        }
//        IsEqual::assert('hello', 'world');
//    }
}
