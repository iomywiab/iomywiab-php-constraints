<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsPropertyExistsTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 20:10:51
 * Version......: v2
 */

/** @noinspection MessDetectorValidationInspection */

/** @noinspection PhpUnused */

/** @noinspection PhpUnusedPrivateFieldInspection */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\parameterized;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsPropertyExists;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsPropertyExistsTest extends ConstraintTestCase
{
    private int $property;

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
        $constraint = new IsPropertyExists(static::class);
        $validSamples = ['property'];
        $invalidSamples = ['propertyXXX'];

        $testValues = new TestValues($validSamples, $invalidSamples);
        parent::__construct($constraint, $testValues, false, $name, $data, $dataName);
    }
}
