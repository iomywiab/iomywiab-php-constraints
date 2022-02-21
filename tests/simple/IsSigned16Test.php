<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsSigned16Test.php
 * Class name...: IsSigned16Test.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsSigned16;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class MaximumTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsSigned16Test extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testIsValid(): void
    {
        $errors = [];
        $constraint = new IsSigned16();
        self::assertEquals($constraint, unserialize(serialize($constraint)));
        self::assertFalse($constraint->isValidValue(null, null, $errors));
        self::assertFalse($constraint->isValidValue(-32768 - 1, null, $errors));
        self::assertTrue($constraint->isValidValue(-32768, null, $errors));
        self::assertTrue($constraint->isValidValue(0, null, $errors));
        self::assertTrue($constraint->isValidValue(32767, null, $errors));
        self::assertFalse($constraint->isValidValue(32767 + 1, null, $errors));
        var_dump($errors);
    }

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        self::expectException(ConstraintViolationException::class);
        try {
            IsSigned16::assert(-32768);
            IsSigned16::assert(0);
            IsSigned16::assert(32767);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsSigned16::assert(32767 + 1);
    }
}