<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsIpv6AddressOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsIpv6AddressOrNullTest.php
 * Class name...: IsIpv6AddressOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:46
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsIpv6AddressOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsIpv6AddressOrNullTest.php
 * Class name...: IsIpv6AddressOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:08:55
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsIpv6AddressOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class Ipv4AddressTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsIpv6AddressOrNullTest extends ConstraintTestCase
{

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        /** @noinspection SpellCheckingInspection */
        $this->checkConstraint(
            new IsIpv6AddressOrNull(),
            [
                '2001:0db8:85a3:08d3:1319:8a2e:0370:7344',
                '2001:db8:0:8d3:0:8a2e:70:7344',
                '2001:db8:0:0:0:0:1428:57ab',
                '2001:db8::1428:57ab',
                '2001:0db8:0:0:8d3:0:0:0',
                '2001:db8:0:0:8d3::',
                '2001:db8::8d3:0:0:0',
                '::ffff:127.0.0.1',
                '::ffff:7f00:1',
                null
            ],
            ['2001:0db8:85a3:08d3:1319:8a2e:0370:734z']
        );

        /** @noinspection SpellCheckingInspection */
        IsIpv6AddressOrNull::assert('::ffff:127.0.0.1');

        self::expectException(ConstraintViolationException::class);
        IsIpv6AddressOrNull::assert('2001:0db8:85a3:08d3:1319:8a2e:0370:734z');
    }

}