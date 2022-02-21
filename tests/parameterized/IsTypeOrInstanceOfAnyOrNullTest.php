<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOrInstanceOfAnyOrNullTest.php
 * Class name...: IsTypeOrInstanceOfAnyOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsTypeOrInstanceOfAnyOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use LogicException;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class IsTypeTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsTypeOrInstanceOfAnyOrNullTest extends ConstraintTestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsTypeOrInstanceOfAnyOrNull([IsType::INT, IsType::FLOAT], [LogicException::class]),
            [-1, 0, 1, -1.0, 0.0, 1.0, new LogicException(), null],
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
            IsTypeOrInstanceOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], [LogicException::class], null);
            IsTypeOrInstanceOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], [LogicException::class], -1);
            IsTypeOrInstanceOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], [LogicException::class], 0);
            IsTypeOrInstanceOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], [LogicException::class], 1);
            IsTypeOrInstanceOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], [LogicException::class], -1.2);
            IsTypeOrInstanceOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], [LogicException::class], 0.0);
            IsTypeOrInstanceOfAnyOrNull::assert([IsType::INT, IsType::FLOAT], [LogicException::class], 1.2);
            IsTypeOrInstanceOfAnyOrNull::assert(
                [IsType::INT, IsType::FLOAT],
                [LogicException::class],
                new LogicException()
            );
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsTypeOrInstanceOfAnyOrNull::assert(
            [IsType::INT, IsType::FLOAT],
            [LogicException::class],
            self::$testException
        );
    }
}