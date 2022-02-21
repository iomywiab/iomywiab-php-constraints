<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsUrlOrNullTest.php
 * Class name...: IsUrlOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

/** @noinspection HttpUrlsUsage */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsUrl;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsUrlOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class IsUrlTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class IsUrlOrNullTest extends ConstraintTestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $this->checkConstraint(
            new IsUrlOrNull(),
            ['http://github.com', 'http://github.com:80', 'ftp://ftp.github.com', 'funny://not.github.com', null],
            ['//github.com']
        );
    }

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        IsUrlOrNull::assert(null);
        IsUrlOrNull::assert('http://github.com');
        IsUrlOrNull::assert('ftp://ftp.github.com');
        IsUrlOrNull::assert('funny://not.github.com');

        self::expectException(ConstraintViolationException::class);
        IsUrlOrNull::assert('//github.com');
    }

    public function testInvalidScheme(): void
    {
        $this->checkInvalid('ftp://github.com');
    }

    /**
     * @param $value
     */
    protected function checkInvalid($value): void
    {
        self::expectException(ConstraintViolationException::class);
        $constraint = $this->getTestUrl();
        $constraint->assertValue($value, strval($value));
    }

    /**
     * @return IsUrl
     * @throws ConstraintViolationException
     */
    protected function getTestUrl(): IsUrl
    {
        return (new IsUrlOrNull())
            ->setSchemes(['http', 'https'])
            ->setHosts(['github.com', 'www.github.com'])
            ->setPorts([80, 443]);
    }

    public function testInvalidHost(): void
    {
        $this->checkInvalid('http://www2.github.com');
    }

    public function testInvalidPort(): void
    {
        $this->checkInvalid('http://github.com:21');
    }
}