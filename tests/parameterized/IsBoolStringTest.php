<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBoolStringTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsBoolStringTest.php
 * Class name...: IsBoolStringTest.php
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
 * File name....: IsBoolStringTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsBoolStringTest.php
 * Class name...: IsBoolStringTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsBoolString;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsBoolStringTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsBoolStringTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsBoolString(),
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
                'inactive'
            ],
            ['TRUE', 'FALSE']
        );
        $this->checkConstraint(
            new IsBoolString(null),
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
                'inactive'
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
            IsBoolString::assert('true');
            IsBoolString::assert('false');
            IsBoolString::assert('1');
            IsBoolString::assert('0');
            IsBoolString::assert('on');
            IsBoolString::assert('off');
            IsBoolString::assert('yes');
            IsBoolString::assert('no');
            IsBoolString::assert('y');
            IsBoolString::assert('n');
            IsBoolString::assert('enabled');
            IsBoolString::assert('disabled');
            IsBoolString::assert('activated');
            IsBoolString::assert('deactivated');
            IsBoolString::assert('active');
            IsBoolString::assert('inactive');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsBoolString::assert('x');
    }
}