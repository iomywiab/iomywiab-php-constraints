<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsSigned32OrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsSigned32OrNullTest.php
 * Class name...: IsSigned32OrNullTest.php
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
 * File name....: IsSigned32OrNullTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsSigned32OrNullTest.php
 * Class name...: IsSigned32OrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsSigned32OrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class MaximumTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsSigned32OrNullTest extends ConstraintTestCase
{

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsSigned32OrNull(),
            [null, -2147483648, 0, 2147483647, -1, 1],
            [-2147483648 - 1, 2147483647 + 1]
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
            IsSigned32OrNull::assert(null);
            IsSigned32OrNull::assert(-2147483648);
            IsSigned32OrNull::assert(0);
            IsSigned32OrNull::assert(2147483647);
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsSigned32OrNull::assert(2147483647 + 1);
    }
}