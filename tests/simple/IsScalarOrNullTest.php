<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsScalarOrNullTest.php
 * Class name...: IsScalarOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsScalarOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class NumericTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsScalarOrNullTest extends ConstraintTestCase
{

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsScalarOrNull(),
            [null, true, false, -1, 0, 1, -1.0, 0.0, 1.0, '', 'abc', 'true', 'false', '-1', '0', '1'],
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
            IsScalarOrNull::assert(null);
            IsScalarOrNull::assert(-1);
            IsScalarOrNull::assert(0);
            IsScalarOrNull::assert(1);
            IsScalarOrNull::assert(1.0);
            IsScalarOrNull::assert('abc');
            IsScalarOrNull::assert(true);
            IsScalarOrNull::assert(false);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsScalarOrNull::assert(new Exception('x'));
    }
}