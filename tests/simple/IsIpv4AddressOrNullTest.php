<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsIpv4AddressOrNullTest.php
 * Class name...: IsIpv4AddressOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsIpv4AddressOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class Ipv4AddressTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsIpv4AddressOrNullTest extends ConstraintTestCase
{

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsIpv4AddressOrNull(),
            [null, '0.0.0.0', '123.123.123.123'],
            ['123.123.123.257']
        );

        IsIpv4AddressOrNull::assert('0.0.0.0');

        self::expectException(ConstraintViolationException::class);
        IsIpv4AddressOrNull::assert('x.x.x.x');
    }

}