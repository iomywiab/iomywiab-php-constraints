<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsUrlOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 20:13:19
 * Version......: v2
 */

/** @noinspection HttpUrlsUsage */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsUrl;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsUrlOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsUrlOrNullTest extends ConstraintTestCase
{
    /**
     * @param mixed $name
     * @param array $data
     * @param mixed $dataName
     */
    public function __construct(
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        $constraint = new IsUrlOrNull();
        $validSamples = [
            'http://github.com',
            'http://github.com:80',
            'ftp://ftp.github.com',
            'funny://not.github.com',
            null
        ];
        $invalidSamples = ['//github.com'];

        $testValues = new TestValues($validSamples, $invalidSamples);
        parent::__construct($constraint, $testValues, false, $name, $data, $dataName);
    }

    /**
     * @return void
     */
    public function testInvalidScheme(): void
    {
        $this->checkInvalid('ftp://github.com');
    }

    /**
     * @param mixed $value
     */
    protected function checkInvalid(mixed $value): void
    {
        $this->expectException(ConstraintViolationException::class);
        $constraint = $this->getTestUrl();
        $constraint->assertValue($value, (string)$value);
    }

    /**
     * @return IsUrl
     * @throws ConstraintViolationException
     */
    protected function getTestUrl(): IsUrl
    {
        return new IsUrlOrNull(
            ['http', 'https'],
            ['github.com', 'www.github.com'],
            [80, 443]
        );
    }

    /**
     * @return void
     */
    public function testInvalidHost(): void
    {
        $this->checkInvalid('http://www2.github.com');
    }

    /**
     * @return void
     */
    public function testInvalidPort(): void
    {
        $this->checkInvalid('http://github.com:21');
    }
}
