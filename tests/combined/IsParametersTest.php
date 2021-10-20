<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsParametersTest.php
 * Class name...: IsParametersTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\combined;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\combined\Constraints;
use iomywiab\iomywiab_php_constraints\constraints\combined\IsParameters;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsGreaterOrEqual;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsGreaterOrEqualOrNull;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsInArray;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringLengthBetween;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringLengthBetweenOrNull;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMaxLength;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMinLength;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsArrayOrNull;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotNull;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringArrayOrNull;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringNotEmpty;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringOrNull;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsUnsigned8;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsUnsigned8OrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class ConstraintsTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsParametersTest extends ConstraintTestCase
{

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $constraint = new IsParameters(
            [
                'str' => new IsStringNotEmpty(),
                'num' => [new IsNotNull(), new IsUnsigned8()]
            ]
        );

        $this->checkConstraint(
            $constraint,
            [['str' => 'abc', 'num' => 2]],
            [['str' => 'abc', 'num' => '2'], ['str' => 1, 'num' => 2], ['str' => 'abc', 'num' => null]]
        );
    }

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        self::expectException(ConstraintViolationException::class);
        $constraint = new IsParameters(
            [
                'str' => new IsStringNotEmpty(),
                'num' => [new IsNotNull(), new IsUnsigned8()]
            ]
        );
        try {
            $constraint->assertValue(['str' => 'abc', 'num' => 2]);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        $constraint->assertValue(['str' => 1, 'num' => 2]);
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testInvalidValues(): void
    {
        $cons = [
            'name' => [new IsStringMinLength(3), new IsStringMaxLength(10)],
            'age' => new IsGreaterOrEqual(18)
        ];
        $this->checkConstraint(
            new IsParameters($cons, true),
            [['name' => 'John', 'age' => 35, 'salary' => 100], ['name' => 'Jim', 'age' => 18, 'salary' => 2]],
            [['name' => 'Jo', 'age' => 35, 'salary' => 100], ['name' => 'Jim', 'age' => 17, 'salary' => 2]]
        );
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testMissingMandatoryValues(): void
    {
        $cons = [
            'name' => [new IsStringMinLength(3), new IsStringMaxLength(10)],
            'age' => new IsGreaterOrEqual(18)
        ];
        $this->checkConstraint(
            new IsParameters($cons, true),
            [['name' => 'John', 'age' => 35, 'salary' => 100], ['name' => 'Jim', 'age' => 18, 'salary' => 2]],
            [['age' => 35, 'salary' => 100], ['name' => 'Jim', 'salary' => 2]]
        );

        $cons = [
            'name' => new Constraints([new IsStringMinLength(3), new IsStringMaxLength(10)]),
            'age' => new IsGreaterOrEqual(18)
        ];
        $this->checkConstraint(
            new IsParameters($cons, true),
            [['name' => 'John', 'age' => 35, 'salary' => 100], ['name' => 'Jim', 'age' => 18, 'salary' => 2]],
            [['age' => 35, 'salary' => 100], ['name' => 'Jim', 'salary' => 2]]
        );
    }

    /**
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testInvalidPatterns(): void
    {
        $cons = [
            'name' => [],
            'age' => null
        ];
        self::expectException(ConstraintViolationException::class);
        IsParameters::assert($cons, []);
    }

    /**
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testEmptyPattern(): void
    {
        IsParameters::assert([], []);
        IsParameters::assert([], ['name' => 'John', 'age' => 35, 'salary' => 100], null, true);

        self::expectException(ConstraintViolationException::class);
        IsParameters::assert([], ['name' => 'John', 'age' => 35, 'salary' => 100]);
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testComplex(): void
    {
        $pattern = [
            'name' => [new IsStringMinLength(3), new IsStringMaxLength(10)],
            'age' => new IsGreaterOrEqualOrNull(18),
            'address' => [
                'street' => new IsStringLengthBetweenOrNull(3, 10),
                'num' => new IsUnsigned8OrNull(),
                'colors' => new IsStringArrayOrNull(),
                'array' => [
                    'a' => new IsStringOrNull(),
                    'b' => new IsUnsigned8OrNull()
                ]
            ]
        ];
        $this->checkConstraint(
            new IsParameters($pattern, true),
            [
                ['name' => 'John', 'salary' => 100],
                ['name' => 'John', 'address' => ['salary' => 100]],
                ['name' => 'John', 'extra' => ['salary' => 100]]
            ],
            [['salary' => 100]]
        );
        $this->checkConstraint(
            new IsParameters($pattern, false),
            [
                ['name' => 'John', 'address' => []],
                [
                    'name' => 'John',
                    'age' => 42,
                    'address' => [
                        'street' => 'abc-street',
                        'num' => 15,
                        'colors' => ['red', 'green'],
                        'array' => ['a' => 'x', 'b' => 1]
                    ]
                ]
            ],
            [
                ['salary' => 100],
                ['name' => 'John', 'salary' => 100],
                ['name' => 'John', 'address' => ['salary' => 100]],
                ['name' => 'John', 'extra' => ['salary' => 100]]
            ]
        );
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testNotifier(): void
    {
        $pattern = [
            'data' => new IsArrayOrNull(),
            'templates' => new IsStringArrayOrNull(),
            'to' => [
                'subscribers' => [
                    'include' => new IsStringOrNull(),
                    'exclude' => new IsStringOrNull()
                ],
                'receivers' => [
                    [
                        'name' => new IsStringLengthBetweenOrNull(1, 80),
                        'channel' => new IsInArray(['email', 'slack', 'sms']),
                        'address' => new IsStringLengthBetween(2, 100)
                    ]
                ]
            ]
        ];
        $this->checkConstraint(
            new IsParameters($pattern, false),
            [
                [
                    'data' => ['name' => 'John', 'age' => 42],
                    'to' => [
                        'receivers' => [
                            [
                                'name' => 'iomywiab',
                                'channel' => 'email',
                                'address' => 'io.github@premium-postfach.de'
                            ],
                            [
                                'channel' => 'slack',
                                'address' => '#channel-test'
                            ],
                            [
                                'channel' => 'sms',
                                'address' => '+1555123456'
                            ]
                        ]
                    ]
                ],
            ],
            []
        );
    }

}