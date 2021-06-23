<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsIntegerOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsIntegerOrNullTest.php
 * Class name...: IsIntegerOrNullTest.php
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
 * File name....: IsIntegerOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsIntegerOrNullTest.php
 * Class name...: IsIntegerOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsIntegerOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class MaximumTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsIntegerOrNullTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsIntegerOrNull(),
            [null, -1, 0, 1, PHP_INT_MIN, PHP_INT_MAX],
            [PHP_INT_MIN - 1, PHP_INT_MAX + 1]
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
            IsIntegerOrNull::assert(null);
            IsIntegerOrNull::assert(PHP_INT_MIN);
            IsIntegerOrNull::assert(0);
            IsIntegerOrNull::assert(PHP_INT_MAX);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsIntegerOrNull::assert(PHP_INT_MAX + 1);
    }
}