<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOrInstanceOfAnyTest.php
 * Class name...: IsTypeOrInstanceOfAnyTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsTypeOrInstanceOfAny;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use LogicException;

/**
 * Class IsTypeTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsTypeOrInstanceOfAnyTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsTypeOrInstanceOfAny([IsType::INT, IsType::FLOAT], [LogicException::class]),
            [-1, 0, 1, -1.0, 0.0, 1.0, new LogicException()],
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
            IsTypeOrInstanceOfAny::assert([IsType::INT, IsType::FLOAT], [LogicException::class], -1);
            IsTypeOrInstanceOfAny::assert([IsType::INT, IsType::FLOAT], [LogicException::class], 0);
            IsTypeOrInstanceOfAny::assert([IsType::INT, IsType::FLOAT], [LogicException::class], 1);
            IsTypeOrInstanceOfAny::assert([IsType::INT, IsType::FLOAT], [LogicException::class], -1.2);
            IsTypeOrInstanceOfAny::assert([IsType::INT, IsType::FLOAT], [LogicException::class], 0.0);
            IsTypeOrInstanceOfAny::assert([IsType::INT, IsType::FLOAT], [LogicException::class], 1.2);
            IsTypeOrInstanceOfAny::assert([IsType::INT, IsType::FLOAT], [LogicException::class], new LogicException());
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsTypeOrInstanceOfAny::assert([IsType::INT, IsType::FLOAT], [LogicException::class], self::$testException);
    }
}