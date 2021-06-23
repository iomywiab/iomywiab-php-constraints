<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsEqualTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsEqualTest.php
 * Class name...: IsEqualTest.php
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
 * File name....: IsEqualTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsEqualTest.php
 * Class name...: IsEqualTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsEqual;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsBoolStringTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsEqualTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsEqual('hello'),
            ['hello'],
            ['world']
        );
        if (8 > PHP_MAJOR_VERSION) {
            $this->checkConstraint(
                new IsEqual('hello', false),
                ['hello', true, 0, 0.0],
                ['world']
            );
        } else {
            $this->checkConstraint(
                new IsEqual('hello', false),
                ['hello', true],
                ['world']
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
            IsEqual::assert('hello', 'hello');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsEqual::assert('hello', 'world');
    }
}