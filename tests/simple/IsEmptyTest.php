<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsEmptyTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 21:04:06
 * Version......: v2
 */

/** @noinspection RedundantSuppression */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsEmpty;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\StandardTestValues;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsEmptyTest extends ConstraintTestCase
{
    /**
     * @param mixed $name
     * @param array $data
     * @param mixed $dataName
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function __construct(
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        $validSamples = [null, false, [], 0, 0.0, '', '0'];
        $invalidSamples = StandardTestValues::get(StandardTestValues::ALL);
        foreach ($validSamples as $validSample) {
            $pos = \array_search($validSample, $invalidSamples, true);
            if (false !== $pos) {
                unset($invalidSamples[$pos]);
            }
        }
        $testValues = new TestValues($validSamples, $invalidSamples);

        parent::__construct(new IsEmpty(), $testValues, false, $name, $data, $dataName);
    }

    /**
     * @return void
     * @noinspection PhpUnitAssertCanBeReplacedWithEmptyInspection
     * @noinspection PhpUnitTestsInspection
     */
    public function testPhpStandards(): void
    {
        self::assertTrue(empty(null));
        self::assertTrue(empty(false));
        self::assertTrue(empty([]));
        self::assertTrue(empty(0));
        self::assertTrue(empty(0.0));

        self::assertTrue(empty(''));
        self::assertFalse(empty('null'));
        self::assertFalse(empty('false'));
        self::assertFalse(empty('[]'));
        self::assertTrue(empty('0'));
        self::assertFalse(empty('0.0'));
    }
}
