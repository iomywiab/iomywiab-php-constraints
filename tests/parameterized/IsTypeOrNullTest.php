<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOrNullTest.php
 * Class name...: IsTypeOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsTypeOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsTypeTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsTypeOrNullTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsTypeOrNull(IsType::FLOAT),
            [-1.0, 0.0, 1.0, 1.2, 0.1, -0.1, null],
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
            IsTypeOrNull::assert(IsType::BOOL, null);
            IsTypeOrNull::assert(IsType::BOOL, true);
            IsTypeOrNull::assert(IsType::BOOL, false);
            IsTypeOrNull::assert(IsType::INT, -1);
            IsTypeOrNull::assert(IsType::INT, 0);
            IsTypeOrNull::assert(IsType::INT, 1);
            IsTypeOrNull::assert(IsType::FLOAT, -1.2);
            IsTypeOrNull::assert(IsType::FLOAT, 0.0);
            IsTypeOrNull::assert(IsType::FLOAT, 1.2);
            IsTypeOrNull::assert(IsType::STRING, '');
            IsTypeOrNull::assert(IsType::STRING, 'abc');
            IsTypeOrNull::assert(IsType::ARRAY, []);
            IsTypeOrNull::assert(IsType::ARRAY, [1, 2]);
            IsTypeOrNull::assert(IsType::OBJECT, new Exception());
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsTypeOrNull::assert(IsType::INT, '123');
    }
}