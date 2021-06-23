<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsLessOrEqualOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsLessOrEqualOrNullTest.php
 * Class name...: IsLessOrEqualOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:46
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsLessOrEqualOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsLessOrEqualOrNullTest.php
 * Class name...: IsLessOrEqualOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsLessOrEqualOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsGreaterTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsLessOrEqualOrNullTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsLessOrEqualOrNull(-2),
            [null, -2, -2.00, -2.01, -3],
            [-1.99]
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
            IsLessOrEqualOrNull::assert(-2, null);
            IsLessOrEqualOrNull::assert(-2, -3);
            IsLessOrEqualOrNull::assert(-2, -2.01);
            IsLessOrEqualOrNull::assert(-2, -2);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsLessOrEqualOrNull::assert(-3, -2);
    }
}