<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringEndingWithOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsStringEndingWithOrNullTest.php
 * Class name...: IsStringEndingWithOrNullTest.php
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
 * File name....: IsStringEndingWithOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsStringEndingWithOrNullTest.php
 * Class name...: IsStringEndingWithOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

/** @noinspection SpellCheckingInspection */

/** @noinspection SpellCheckingInspection */

/** @noinspection SpellCheckingInspection */

/** @noinspection SpellCheckingInspection */

/** @noinspection SpellCheckingInspection */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringEndingWithOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsBoolStringTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsStringEndingWithOrNullTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsStringEndingWithOrNull('abc'),
            ['abc', 'xabc', null],
            ['abcx', 'xabcx']
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
            IsStringEndingWithOrNull::assert('abc', null);
            IsStringEndingWithOrNull::assert('abc', 'abc');
            IsStringEndingWithOrNull::assert('abc', 'xabc');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsStringEndingWithOrNull::assert('abc', 'abcx');
    }
}