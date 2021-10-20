<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOfAnyOrNullTest.php
 * Class name...: IsTypeOfAnyOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsTypeOfAnyOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsTypeTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsTypeOfAnyOrNullTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsTypeOfAnyOrNull([IsType::INT, IsType::FLOAT]),
            [-1, 0, 1, -1.0, 0.0, 1.0, null],
            ['x', true, false, [], self::$testException]
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
            IsTypeOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], null);
            IsTypeOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], -1);
            IsTypeOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], 0);
            IsTypeOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], 1);
            IsTypeOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], -1.2);
            IsTypeOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], 0.0);
            IsTypeOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], 1.2);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsTypeOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], true);
    }
}