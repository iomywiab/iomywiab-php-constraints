<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsAOfOrNullTest.php
 * Class name...: IsAOfOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Error;
use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsAOfOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use RuntimeException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class InstanceTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsAOfOrNullTest extends ConstraintTestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsAOfOrNull(Exception::class),
            [null, self::$testException, new Exception(), new RuntimeException()],
            [new Error()]
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
            IsAOfOrNull::assert(Exception::class, null);
            IsAOfOrNull::assert(Exception::class, new Exception());
            IsAOfOrNull::assert(Exception::class, new RuntimeException());
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsAOfOrNull::assert(Exception::class, new Error());
    }
}