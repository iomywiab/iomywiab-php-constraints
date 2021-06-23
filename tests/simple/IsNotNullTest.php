<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsNotNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsNotNullTest.php
 * Class name...: IsNotNullTest.php
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
 * File name....: IsNotNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsNotNullTest.php
 * Class name...: IsNotNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class NotNullTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsNotNullTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsNotNull(),
            [
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
            IsNotNull::assert('1');
            IsNotNull::assert(1);
            IsNotNull::assert('');
            IsNotNull::assert([]);
            IsNotNull::assert(0);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsNotNull::assert(null);
    }
}