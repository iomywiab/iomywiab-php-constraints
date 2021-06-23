<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsFalseTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsFalseTest.php
 * Class name...: IsFalseTest.php
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
 * File name....: IsFalseTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsFalseTest.php
 * Class name...: IsFalseTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsFalse;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class DomainTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsFalseTest extends ConstraintTestCase
{

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        /** @noinspection PhpExpressionWithSameOperandsInspection */
        $this->checkConstraint(
            new IsFalse(),
            [false, (1 != 1), (1 !== 1), (1 == 2), (1 === 2)],
            [true, (1 == 1), (1 === 1), (1 != 2), (1 !== 2)]
        );

        IsFalse::assert(false);

        self::expectException(ConstraintViolationException::class);
        IsFalse::assert(true);
    }

}