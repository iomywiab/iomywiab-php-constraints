<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBooleanOrBoolStringTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 20:21:34
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsBooleanOrBoolString;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsBooleanOrBoolStringTest extends ConstraintTestCase
{
    /**
     * @param mixed $name
     * @param array $data
     * @param mixed $dataName
     */
    public function __construct(
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        $validSamples = [
            'true',
            'false',
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
        ];
        $testValues = new TestValues($validSamples, ['TRUE', 'FALSE']);

        parent::__construct(new IsBooleanOrBoolString(), $testValues, false, $name, $data, $dataName);
    }

//    /**
//     * @throws ExpectationFailedException
//     * @throws InvalidArgumentException
//     * @throws ConstraintViolationException
//     */
//    public function testIsValid(): void
//    {
//        $this->checkConstraint(
//            new IsBooleanOrBoolString(),
//            //array_keys(IsBoolString::DEFAULT_BOOLEAN_STRINGS),
//            [
//                Format::TRUE_STRING,
//                Format::FALSE_STRING,
//                '1',
//                '0',
//                'on',
//                'off',
//                'yes',
//                'no',
//                'y',
//                'n',
//                'enabled',
//                'disabled',
//                'activated',
//                'deactivated',
//                'active',
//                'inactive',
//                true,
//                false
//            ],
//            ['TRUE', 'FALSE']
//        );
//        $this->checkConstraint(
//            new IsBooleanOrBoolString(null),
//            //array_keys(IsBoolString::DEFAULT_BOOLEAN_STRINGS),
//            [
//                Format::TRUE_STRING,
//                Format::FALSE_STRING,
//                '1',
//                '0',
//                'on',
//                'off',
//                'yes',
//                'no',
//                'y',
//                'n',
//                'enabled',
//                'disabled',
//                'activated',
//                'deactivated',
//                'active',
//                'inactive',
//                true,
//                false
//            ],
//            ['TRUE', 'FALSE']
//        );
//    }
//
//    /**
//     * @throws ConstraintViolationException
//     * @throws Exception
//     */
//    public function testAssert(): void
//    {
//        self::expectException(ConstraintViolationException::class);
//        try {
//            IsBooleanOrBoolString::assert(true);
//            IsBooleanOrBoolString::assert(false);
//            IsBooleanOrBoolString::assert('true');
//            IsBooleanOrBoolString::assert('false');
//            IsBooleanOrBoolString::assert('1');
//            IsBooleanOrBoolString::assert('0');
//            IsBooleanOrBoolString::assert('on');
//            IsBooleanOrBoolString::assert('off');
//            IsBooleanOrBoolString::assert('yes');
//            IsBooleanOrBoolString::assert('no');
//            IsBooleanOrBoolString::assert('y');
//            IsBooleanOrBoolString::assert('n');
//            IsBooleanOrBoolString::assert('enabled');
//            IsBooleanOrBoolString::assert('disabled');
//            IsBooleanOrBoolString::assert('activated');
//            IsBooleanOrBoolString::assert('deactivated');
//            IsBooleanOrBoolString::assert('active');
//            IsBooleanOrBoolString::assert('inactive');
//        } catch (Exception $cause) {
//            throw new Exception('Unexpected exception', 0, $cause);
//        }
//        IsBooleanOrBoolString::assert('x');
//    }
}
