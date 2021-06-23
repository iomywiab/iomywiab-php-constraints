<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringMinLengthOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsStringMinLengthOrNullTest.php
 * Class name...: IsStringMinLengthOrNullTest.php
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
 * File name....: IsStringMinLengthOrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsStringMinLengthOrNullTest.php
 * Class name...: IsStringMinLengthOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMinLengthOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsStringMaxLengthTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsStringMinLengthOrNullTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsStringMinLengthOrNull(3),
            ['123', 'abc', 'true', 'false', null],
            ['12']
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
            IsStringMinLengthOrNull::assert(3, null);
            IsStringMinLengthOrNull::assert(3, '123');
            IsStringMinLengthOrNull::assert(3, '1234');
            IsStringMinLengthOrNull::assert(3, '12345');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsStringMinLengthOrNull::assert(3, '12');
    }
}