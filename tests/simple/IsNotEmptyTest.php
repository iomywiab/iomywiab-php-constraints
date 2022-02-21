<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsNotEmptyTest.php
 * Class name...: IsNotEmptyTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotEmpty;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class IsNotEmptyTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsNotEmptyTest extends ConstraintTestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsNotEmpty(),
            [
                true,
                -1,
                1,
                -1.0,
                1.0,
                'abc',
                'true',
                'false',
                '-1',
                '1',
                [null],
                [true],
                [false],
                [-1],
                [0],
                [1],
                [-1.0],
                [0.0],
                [1.0],
                [''],
                ['abc'],
                ['true'],
                ['false'],
                ['-1'],
                ['0'],
                ['1'],
                self::$testException
            ],
            []
        );
    }

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        self::expectException(ConstraintViolationException::class);
        try {
            IsNotEmpty::assert(1);
            IsNotEmpty::assert('abc');
            IsNotEmpty::assert([1, 2, 3]);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsNotEmpty::assert(null);
    }
}