<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsMethodExistsTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsMethodExistsTest.php
 * Class name...: IsMethodExistsTest.php
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
 * File name....: IsMethodExistsTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/parameterized/IsMethodExistsTest.php
 * Class name...: IsMethodExistsTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsKeyExists;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsMethodExists;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsGreaterTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsMethodExistsTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsMethodExists(static::class),
            ['testIsValid'],
            ['testIsValidXXX']
        );
    }

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        self::expectException(ConstraintViolationException::class);
        $array = [1 => 11, 2 => 22, 3 => 33, 6 => 66, 'a' => 77, 'b' => 88];
        try {
            IsKeyExists::assert($array, 1);
            IsKeyExists::assert($array, 2);
            IsKeyExists::assert($array, 3);
            IsKeyExists::assert($array, 6);
            IsKeyExists::assert($array, 'a');
            IsKeyExists::assert($array, 'b');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        IsKeyExists::assert($array, 4);
    }
}