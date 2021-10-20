<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsImplementingInterfaceTest.php
 * Class name...: IsImplementingInterfaceTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsGreater;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsImplementingInterface;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotEmpty;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\interfaces\SimpleConstraintInterface;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsGreaterTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsImplementingInterfaceTest extends ConstraintTestCase
{

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsImplementingInterface(SimpleConstraintInterface::class),
            [new IsNotNull(), [new IsNotEmpty(), new IsNotNull()]],
            [new IsGreater(2)]
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
            IsImplementingInterface::assert(SimpleConstraintInterface::class, new IsNotNull());
            IsImplementingInterface::assert(SimpleConstraintInterface::class, [new IsNotEmpty(), new IsNotNull()]);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsImplementingInterface::assert(SimpleConstraintInterface::class, new IsGreater(2));
    }
}