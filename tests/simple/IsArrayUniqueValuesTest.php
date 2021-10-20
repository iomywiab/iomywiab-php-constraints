<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsArrayUniqueValuesTest.php
 * Class name...: IsArrayUniqueValuesTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsArrayUniqueValues;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class UniqueTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsArrayUniqueValuesTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsArrayUniqueValues(),
            [
                null,
                true,
                false,
                -1,
                0,
                1,
                -1.0,
                0.0,
                1.0,
                '',
                'abc',
                'true',
                'false',
                '-1',
                '0',
                '1',
                [],
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
                self::$testException,
                [1, 2],
                [1, 2, 3],
                ['a', 'b', 'c']
            ],
            [[1, 2, 3, 2, 2, 2], ['a', 'b', 'c', 'a', 'c', 'd']]
        );

        IsArrayUniqueValues::assert([1, 2, 3]);

        self::expectException(ConstraintViolationException::class);
        IsArrayUniqueValues::assert([1, 2, 3, 1]);
    }

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        self::expectException(ConstraintViolationException::class);
        try {
            IsArrayUniqueValues::assert(1);
            IsArrayUniqueValues::assert(2.3);
            IsArrayUniqueValues::assert('x');
            IsArrayUniqueValues::assert(null);
            IsArrayUniqueValues::assert([]);
            IsArrayUniqueValues::assert([1]);
            IsArrayUniqueValues::assert([1, 2]);
            IsArrayUniqueValues::assert([1, 2, 3]);
            IsArrayUniqueValues::assert(['a', 'b', 'c']);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsArrayUniqueValues::assert(['a', 'b', 'c', 'a', 'c', 'd']);
    }
}