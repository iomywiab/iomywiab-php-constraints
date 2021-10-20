<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBooleanOrBoolStringOrNullTest.php
 * Class name...: IsBooleanOrBoolStringOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsBooleanOrBoolStringOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsBoolStringTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsBooleanOrBoolStringOrNullTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsBooleanOrBoolStringOrNull(),
            //array_keys(IsBoolString::DEFAULT_BOOLEAN_STRINGS),
            [
                Format::TRUE_STRING,
                Format::FALSE_STRING,
                '1',
                '0',
                'on',
                'off',
                'yes',
                'no',
                'y',
                'n',
                'enabled',
                'disabled',
                'activated',
                'deactivated',
                'active',
                'inactive',
                true,
                false,
                null
            ],
            ['TRUE', 'FALSE']
        );
        $this->checkConstraint(
            new IsBooleanOrBoolStringOrNull(null),
            //array_keys(IsBoolString::DEFAULT_BOOLEAN_STRINGS),
            [
                Format::TRUE_STRING,
                Format::FALSE_STRING,
                '1',
                '0',
                'on',
                'off',
                'yes',
                'no',
                'y',
                'n',
                'enabled',
                'disabled',
                'activated',
                'deactivated',
                'active',
                'inactive',
                true,
                false,
                null
            ],
            ['TRUE', 'FALSE']
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
            IsBooleanOrBoolStringOrNull::assert(null);
            IsBooleanOrBoolStringOrNull::assert(true);
            IsBooleanOrBoolStringOrNull::assert(false);
            IsBooleanOrBoolStringOrNull::assert('true');
            IsBooleanOrBoolStringOrNull::assert('false');
            IsBooleanOrBoolStringOrNull::assert('1');
            IsBooleanOrBoolStringOrNull::assert('0');
            IsBooleanOrBoolStringOrNull::assert('on');
            IsBooleanOrBoolStringOrNull::assert('off');
            IsBooleanOrBoolStringOrNull::assert('yes');
            IsBooleanOrBoolStringOrNull::assert('no');
            IsBooleanOrBoolStringOrNull::assert('y');
            IsBooleanOrBoolStringOrNull::assert('n');
            IsBooleanOrBoolStringOrNull::assert('enabled');
            IsBooleanOrBoolStringOrNull::assert('disabled');
            IsBooleanOrBoolStringOrNull::assert('activated');
            IsBooleanOrBoolStringOrNull::assert('deactivated');
            IsBooleanOrBoolStringOrNull::assert('active');
            IsBooleanOrBoolStringOrNull::assert('inactive');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsBooleanOrBoolStringOrNull::assert('x');
    }
}