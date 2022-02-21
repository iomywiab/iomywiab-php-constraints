<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOfAnyTest.php
 * Class name...: IsTypeOfAnyTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsTypeOfAny;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class IsTypeTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsTypeOfAnyTest extends ConstraintTestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsTypeOfAny([IsType::INT, IsType::FLOAT]),
            [-1, 0, 1, -1.0, 0.0, 1.0],
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
            IsTypeOfAny::assert([IsType::INT, IsType::FLOAT], -1);
            IsTypeOfAny::assert([IsType::INT, IsType::FLOAT], 0);
            IsTypeOfAny::assert([IsType::INT, IsType::FLOAT], 1);
            IsTypeOfAny::assert([IsType::INT, IsType::FLOAT], -1.2);
            IsTypeOfAny::assert([IsType::INT, IsType::FLOAT], 0.0);
            IsTypeOfAny::assert([IsType::INT, IsType::FLOAT], 1.2);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsTypeOfAny::assert([IsType::INT, IsType::FLOAT], true);
    }
}