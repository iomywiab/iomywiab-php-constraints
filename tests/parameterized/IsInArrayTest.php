<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInArrayTest.php
 * Class name...: IsInArrayTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsInArray;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class IsInArrayTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsInArrayTest extends ConstraintTestCase
{

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsInArray(['a', 'b', 'c', 1, true, [1, 2]]),
            [1, true, 'a', 'b', 'c', [1, 2]],
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
            IsInArray::assert($array, 'a');
            IsInArray::assert($array, 'b');
            IsInArray::assert($array, 'c');
            IsInArray::assert($array, 1, null, true);
            IsInArray::assert($array, '1', null, false);
            IsInArray::assert($array, true);
            IsInArray::assert($array, [1, 2]);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsInArray::assert($array, null);
    }
}