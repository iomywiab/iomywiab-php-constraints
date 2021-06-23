<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsIpv4AddressTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsIpv4AddressTest.php
 * Class name...: IsIpv4AddressTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:45
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsIpv4AddressTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsIpv4AddressTest.php
 * Class name...: IsIpv4AddressTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsIpv4Address;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class Ipv4AddressTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsIpv4AddressTest extends ConstraintTestCase
{

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsIpv4Address(),
            ['0.0.0.0', '123.123.123.123'],
            ['123.123.123.257']
        );

        IsIpv4Address::assert('0.0.0.0');

        self::expectException(ConstraintViolationException::class);
        IsIpv4Address::assert('x.x.x.x');
    }

}