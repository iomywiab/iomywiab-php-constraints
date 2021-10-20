<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsResourceOrNullTest.php
 * Class name...: IsResourceOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsResourceOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsRegExTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsResourceOrNullTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $stdout = fopen('php://stdout', 'w');

        $this->checkConstraint(
            new IsResourceOrNull(),
            [$stdout, null],
            [self::$testException]
        );
        $this->checkConstraint(
            new IsResourceOrNull('stream'),
            [$stdout, null],
            [self::$testException]
        );
    }

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        self::expectException(ConstraintViolationException::class);
        $stdout = fopen('php://stdout', 'w');
        try {
            IsResourceOrNull::assert(null);
            IsResourceOrNull::assert($stdout);
            IsResourceOrNull::assert($stdout, null, 'stream');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsResourceOrNull::assert('x');
    }
}