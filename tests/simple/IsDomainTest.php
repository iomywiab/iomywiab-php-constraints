<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsDomainTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsDomainTest.php
 * Class name...: IsDomainTest.php
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
 * File name....: IsDomainTest.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/simple/IsDomainTest.php
 * Class name...: IsDomainTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 16:40:22
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsDomain;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;

/**
 * Class DomainTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsDomainTest extends ConstraintTestCase
{

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsDomain(),
            ['github.com', 'ftp.github.com', 'www.github.com'],
            ['//github.com']
        );

        IsDomain::assert('ftp.github.com');

        self::expectException(ConstraintViolationException::class);
        IsDomain::assert('//github.com');
    }

}