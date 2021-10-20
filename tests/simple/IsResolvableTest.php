<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsResolvableTest.php
 * Class name...: IsResolvableTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsResolvable;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsResolvableTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsResolvableTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValidResolving(): void
    {
        $this->checkConstraint(
            new IsResolvable(),
            [0, '8.8.8.8', 'github.com'],
            ['notfound-iomywiab.com'],
            true
        );

        IsResolvable::assert('github.com');

        self::expectException(ConstraintViolationException::class);
        IsResolvable::assert('notfound-iomywiab.com');
    }

}