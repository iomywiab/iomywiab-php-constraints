<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsEmailAddressTest.php
 * Class name...: IsEmailAddressTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsEmailAddress;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class EmailAddressTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsEmailAddressTest extends ConstraintTestCase
{

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsEmailAddress(),
            ['a@bc.de', 'user@github.com', 'firstname.lastname@github.com'],
            ['//github.com', '@github.com', 'user', 'firstname.lastname', 'user@', 'firstname.lastname@']
        );

        IsEmailAddress::assert('user@github.com');

        self::expectException(ConstraintViolationException::class);
        IsEmailAddress::assert('@github.com');
    }

}