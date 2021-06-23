<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsTypeTest.php
 * Class name...: IsTypeTest.php
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
 * File name....: IsTypeTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsTypeTest.php
 * Class name...: IsTypeTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsTypeTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsTypeTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsType(IsType::FLOAT),
            [-1.0, 0.0, 1.0, 1.2, 0.1, -0.1],
            []
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
            IsType::assert(IsType::BOOL, true);
            IsType::assert(IsType::BOOL, false);
            IsType::assert(IsType::INT, -1);
            IsType::assert(IsType::INT, 0);
            IsType::assert(IsType::INT, 1);
            IsType::assert(IsType::FLOAT, -1.2);
            IsType::assert(IsType::FLOAT, 0.0);
            IsType::assert(IsType::FLOAT, 1.2);
            IsType::assert(IsType::STRING, '');
            IsType::assert(IsType::STRING, 'abc');
            IsType::assert(IsType::ARRAY, []);
            IsType::assert(IsType::ARRAY, [1, 2]);
            IsType::assert(IsType::OBJECT, new Exception());
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsType::assert(IsType::INT, '123');
    }
}