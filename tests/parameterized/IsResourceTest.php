<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsResourceTest.php
 * Class name...: IsResourceTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsResource;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class IsRegExTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsResourceTest extends ConstraintTestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $stdout = fopen('php://stdout', 'w');

        $this->checkConstraint(
            new IsResource(),
            [$stdout],
            [self::$testException]
        );
        $this->checkConstraint(
            new IsResource('stream'),
            [$stdout],
            [self::$testException]
        );
    }

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        self::expectException(ConstraintViolationException::class);
        $stdout = fopen('php://stdout', 'w');
        try {
            IsResource::assert($stdout);
            IsResource::assert($stdout, null, 'stream');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsResource::assert(null);
    }
}