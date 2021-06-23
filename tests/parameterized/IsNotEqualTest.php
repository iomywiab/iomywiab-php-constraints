<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsNotEqualTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsNotEqualTest.php
 * Class name...: IsNotEqualTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:45
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsNotEqualTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsNotEqualTest.php
 * Class name...: IsNotEqualTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsNotEqual;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsBoolStringTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsNotEqualTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsNotEqual('hello'),
            [
                'world',
                null,
                -1,
                0,
                1,
                -1.0,
                0.0,
                1.0,
                true,
                false,
                [],
                '',
                'abc',
                'true',
                'false',
                '-1',
                '0',
                '1',
                '-1.0',
                '0.0',
                '-1.0',
                [null],
                [-1],
                [0],
                [1],
                [-1.0],
                [0.0],
                [1.0],
                [true],
                [false],
                [''],
                ['abc'],
                self::$testException
            ],
            ['hello']
        );
        if (8 > PHP_MAJOR_VERSION) {
            $this->checkConstraint(
                new IsNotEqual('hello', false),
                [
                    'world',
                    null,
                    -1, /*0,*/ 1,
                    -1.0, /*0.0,*/ 1.0, /*true,*/ false,
                    [],
                    '',
                    'abc',
                    'true',
                    'false',
                    '-1',
                    '0',
                    '1',
                    '-1.0',
                    '0.0',
                    '-1.0',
                    [null],
                    [-1],
                    [0],
                    [1],
                    [-1.0],
                    [0.0],
                    [1.0],
                    [true],
                    [false],
                    [''],
                    ['abc'],
                    self::$testException
                ],
                ['hello']
            );
        } else {
            $this->checkConstraint(
                new IsNotEqual('hello', false),
                [
                    'world',
                    null,
                    -1,
                    0,
                    1,
                    -1.0,
                    0.0,
                    1.0, /*true,*/ false,
                    [],
                    '',
                    'abc',
                    'true',
                    'false',
                    '-1',
                    '0',
                    '1',
                    '-1.0',
                    '0.0',
                    '-1.0',
                    [null],
                    [-1],
                    [0],
                    [1],
                    [-1.0],
                    [0.0],
                    [1.0],
                    [true],
                    [false],
                    [''],
                    ['abc'],
                    self::$testException
                ],
                ['hello']
            );
        }
    }

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        self::expectException(ConstraintViolationException::class);
        try {
            IsNotEqual::assert('hello', 'world');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsNotEqual::assert('hello', 'hello');
    }
}