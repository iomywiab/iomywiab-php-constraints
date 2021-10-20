<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsValidTypeArrayTest.php
 * Class name...: IsValidTypeArrayTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsValidArrayKey;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsValidType;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsValidTypeArray;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsBoolStringTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsValidTypeArrayTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsValidTypeArray(),
            [IsValidType::ALL_TYPES, [IsValidType::INT, IsValidType::FLOAT]],
            [[IsValidType::INT, IsValidType::FLOAT, 'abc'], [IsValidType::INT, IsValidType::FLOAT, 'xyz']]
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
            IsValidArrayKey::assert(IsValidType::STRING);
            IsValidArrayKey::assert(IsValidType::ARRAY);
            IsValidArrayKey::assert(IsValidType::BOOL);
            IsValidArrayKey::assert(IsValidType::FLOAT);
            IsValidArrayKey::assert(IsValidType::INT);
            IsValidArrayKey::assert(IsValidType::OBJECT);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsValidArrayKey::assert(['abc']);
    }
}