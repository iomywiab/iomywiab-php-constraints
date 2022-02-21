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
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class IsResolvableTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsResolvableTest extends ConstraintTestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
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