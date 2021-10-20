<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBooleanOrBoolStringTest.php
 * Class name...: IsBooleanOrBoolStringTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsBooleanOrBoolString;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsBoolStringTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsBooleanOrBoolStringTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsBooleanOrBoolString(),
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
                false
            ],
            ['TRUE', 'FALSE']
        );
        $this->checkConstraint(
            new IsBooleanOrBoolString(null),
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
                false
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
            IsBooleanOrBoolString::assert(true);
            IsBooleanOrBoolString::assert(false);
            IsBooleanOrBoolString::assert('true');
            IsBooleanOrBoolString::assert('false');
            IsBooleanOrBoolString::assert('1');
            IsBooleanOrBoolString::assert('0');
            IsBooleanOrBoolString::assert('on');
            IsBooleanOrBoolString::assert('off');
            IsBooleanOrBoolString::assert('yes');
            IsBooleanOrBoolString::assert('no');
            IsBooleanOrBoolString::assert('y');
            IsBooleanOrBoolString::assert('n');
            IsBooleanOrBoolString::assert('enabled');
            IsBooleanOrBoolString::assert('disabled');
            IsBooleanOrBoolString::assert('activated');
            IsBooleanOrBoolString::assert('deactivated');
            IsBooleanOrBoolString::assert('active');
            IsBooleanOrBoolString::assert('inactive');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsBooleanOrBoolString::assert('x');
    }
}