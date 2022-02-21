<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsExpressionTest.php
 * Class name...: IsExpressionTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

/** @noinspection PhpDeprecationInspection */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsExpression;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class DomainTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsExpressionTest extends ConstraintTestCase
{

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        /** @noinspection PhpExpressionWithSameOperandsInspection */
        $this->checkConstraint(
            new IsExpression(),
            [true, (1 == 1), (1 === 1), (1 != 2), (1 !== 2)],
            [false, (1 != 1), (1 !== 1), (1 == 2), (1 === 2)]
        );

        IsExpression::assert(true);

        self::expectException(ConstraintViolationException::class);
        IsExpression::assert(false);
    }

}