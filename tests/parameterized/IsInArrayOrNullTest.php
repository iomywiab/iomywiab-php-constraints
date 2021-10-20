<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInArrayOrNullTest.php
 * Class name...: IsInArrayOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsInArrayOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsInArrayTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsInArrayOrNullTest extends ConstraintTestCase
{

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsInArrayOrNull(['a', 'b', 'c', 1, true, [1, 2]]),
            [1, true, 'a', 'b', 'c', [1, 2], null],
            ['d', 5]
        );
    }

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        self::expectException(ConstraintViolationException::class);
        $array = ['a', 'b', 'c', 1, true, [1, 2]];
        try {
            IsInArrayOrNull::assert($array, 'a');
            IsInArrayOrNull::assert($array, 'b');
            IsInArrayOrNull::assert($array, 'c');
            IsInArrayOrNull::assert($array, 1, null, true);
            IsInArrayOrNull::assert($array, '1', null, false);
            IsInArrayOrNull::assert($array, true);
            IsInArrayOrNull::assert($array, [1, 2]);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsInArrayOrNull::assert($array, 'x');
    }
}