<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsUUIDTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsUUIDTest.php
 * Class name...: IsUUIDTest.php
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
 * File name....: IsUUIDTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsUUIDTest.php
 * Class name...: IsUUIDTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsUUID;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsStringTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsUUIDTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        /** @noinspection SpellCheckingInspection */
        $this->checkConstraint(
            new IsUUID(),
            ['00000000-0000-0000-0000-000000000000', '550e8400-e29b-11d4-a716-446655440000'],
            ['550e8400-WXYZ-11d4-a716-446655440000']
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
            IsUUID::assert('00000000-0000-0000-0000-000000000000');
            IsUUID::assert('550e8400-e29b-11d4-a716-446655440000');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsUUID::assert(1);
    }
}