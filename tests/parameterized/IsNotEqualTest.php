<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsNotEqualTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:31:10
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsNotEqual;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\StandardTestValues;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsNotEqualTest extends ConstraintTestCase
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
        $constraint = new IsNotEqual('hello');
        $validSamples = StandardTestValues::get(StandardTestValues::ALL);
        $invalidSamples = ['hello'];

        $testValues = new TestValues($validSamples, $invalidSamples);
        parent::__construct($constraint, $testValues, false, $name, $data, $dataName);
    }
//
//    /**
//     * @throws ExpectationFailedException
//     * @throws InvalidArgumentException
//     * @throws ConstraintViolationException
//     */
//    public function testIsValid(): void
//    {
//        $this->checkConstraint(
//            new IsNotEqual('hello'),
//            [
//                'world',
//                null,
//                -1,
//                0,
//                1,
//                -1.0,
//                0.0,
//                1.0,
//                true,
//                false,
//                [],
//                '',
//                'abc',
//                'true',
//                'false',
//                '-1',
//                '0',
//                '1',
//                '-1.0',
//                '0.0',
//                '-1.0',
//                [null],
//                [-1],
//                [0],
//                [1],
//                [-1.0],
//                [0.0],
//                [1.0],
//                [true],
//                [false],
//                [''],
//                ['abc'],
//                self::$testException
//            ],
//            ['hello']
//        );
//        if (8 > PHP_MAJOR_VERSION) {
//            $this->checkConstraint(
//                new IsNotEqual('hello', false),
//                [
//                    'world',
//                    null,
//                    -1, /*0,*/ 1,
//                    -1.0, /*0.0,*/ 1.0, /*true,*/ false,
//                    [],
//                    '',
//                    'abc',
//                    'true',
//                    'false',
//                    '-1',
//                    '0',
//                    '1',
//                    '-1.0',
//                    '0.0',
//                    '-1.0',
//                    [null],
//                    [-1],
//                    [0],
//                    [1],
//                    [-1.0],
//                    [0.0],
//                    [1.0],
//                    [true],
//                    [false],
//                    [''],
//                    ['abc'],
//                    self::$testException
//                ],
//                ['hello']
//            );
//        } else {
//            $this->checkConstraint(
//                new IsNotEqual('hello', false),
//                [
//                    'world',
//                    null,
//                    -1,
//                    0,
//                    1,
//                    -1.0,
//                    0.0,
//                    1.0, /*true,*/ false,
//                    [],
//                    '',
//                    'abc',
//                    'true',
//                    'false',
//                    '-1',
//                    '0',
//                    '1',
//                    '-1.0',
//                    '0.0',
//                    '-1.0',
//                    [null],
//                    [-1],
//                    [0],
//                    [1],
//                    [-1.0],
//                    [0.0],
//                    [1.0],
//                    [true],
//                    [false],
//                    [''],
//                    ['abc'],
//                    self::$testException
//                ],
//                ['hello']
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
//            IsNotEqual::assert('hello', 'world');
//        } catch (Exception $cause) {
//            throw new Exception('Unexpected exception', 0, $cause);
//        }
//        IsNotEqual::assert('hello', 'hello');
//    }
}
