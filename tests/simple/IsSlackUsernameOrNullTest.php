<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsSlackUsernameOrNullTest.php
 * Class name...: IsSlackUsernameOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:34
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsSlackUsernameOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class IsSlackUsernameTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsSlackUsernameOrNullTest extends ConstraintTestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsSlackUsernameOrNull(),
            [null, '@username', '#channel', 'username', 'abc', 'true', 'false'],
            ['@', '#', '@@', '##', 'username@channel']
        );

        IsSlackUsernameOrNull::assert(null);
        IsSlackUsernameOrNull::assert('@slack.user');

        self::expectException(ConstraintViolationException::class);
        IsSlackUsernameOrNull::assert('slack.user!');
    }

}