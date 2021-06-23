<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsNumericTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsNumericTest.php
 * Class name...: IsNumericTest.php
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
 * File name....: IsNumericTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsNumericTest.php
 * Class name...: IsNumericTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNumeric;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class NumericTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsNumericTest extends ConstraintTestCase
{

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsNumeric(),
            [-1, 0, 1, -1.0, 0.0, 1.0, '-1', '0', '1'],
            []
        );

        IsNumeric::assert(1);

        self::expectException(ConstraintViolationException::class);
        IsNumeric::assert('x');
    }

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        self::expectException(ConstraintViolationException::class);
        try {
            IsNumeric::assert(-1);
            IsNumeric::assert(0);
            IsNumeric::assert(1);
            IsNumeric::assert(7.7);
            IsNumeric::assert('+8.3');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsNumeric::assert('x');
    }
}