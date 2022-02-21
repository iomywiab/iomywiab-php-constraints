<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsSigned64OrNullTest.php
 * Class name...: IsSigned64OrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsSigned64OrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class MaximumTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsSigned64OrNullTest extends ConstraintTestCase
{

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        /** @noinspection PhpCastIsUnnecessaryInspection */
        $this->checkConstraint(
            new IsSigned64OrNull(),
            [null, (int)-9223372036854775808, 0, 9223372036854775807, -1, 1],
            [(int)-9223372036854775808 - 1, 9223372036854775807 + 1]
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
            IsSigned64OrNull::assert(null);
            /** @noinspection PhpCastIsUnnecessaryInspection */
            IsSigned64OrNull::assert((int)-9223372036854775808);
            IsSigned64OrNull::assert(0);
            IsSigned64OrNull::assert(9223372036854775807);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsSigned64OrNull::assert(9223372036854775807 + 1);
    }
}