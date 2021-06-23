<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBoolStringOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsBoolStringOrNullTest.php
 * Class name...: IsBoolStringOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:45
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBoolStringOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsBoolStringOrNullTest.php
 * Class name...: IsBoolStringOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsBoolStringOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsBoolStringTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsBoolStringOrNullTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsBoolStringOrNull(),
            //array_keys(IsBoolString::DEFAULT_BOOLEAN_STRINGS),
            [
                null,
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
            IsBoolStringOrNull::assert(null);
            IsBoolStringOrNull::assert('true');
            IsBoolStringOrNull::assert('false');
            IsBoolStringOrNull::assert('1');
            IsBoolStringOrNull::assert('0');
            IsBoolStringOrNull::assert('on');
            IsBoolStringOrNull::assert('off');
            IsBoolStringOrNull::assert('yes');
            IsBoolStringOrNull::assert('no');
            IsBoolStringOrNull::assert('y');
            IsBoolStringOrNull::assert('n');
            IsBoolStringOrNull::assert('enabled');
            IsBoolStringOrNull::assert('disabled');
            IsBoolStringOrNull::assert('activated');
            IsBoolStringOrNull::assert('deactivated');
            IsBoolStringOrNull::assert('active');
            IsBoolStringOrNull::assert('inactive');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsBoolStringOrNull::assert('x');
    }
}