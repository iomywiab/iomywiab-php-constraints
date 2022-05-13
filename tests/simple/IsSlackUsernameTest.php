<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsSlackUsernameTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:30:56
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsSlackUsername;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsSlackUsernameTest extends ConstraintTestCase
{
    /**
     * @param mixed       $name
     * @param array       $data
     * @param mixed $dataName
     */
    public function __construct(
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        $validSamples = [
            '@username',
            '#channel',
            'username',
            'abc',
            'null',
            'true',
            'false',
            '@slack.user',
            'This ia a long string with some repetitions. This ia a long string with some repetitions. '
        ];
        $invalidSamples = ['@', '#', '@@', '##', 'username@channel', 'slack.user!'];
        $testValues = new TestValues($validSamples, $invalidSamples);

        parent::__construct(new IsSlackUsername(), $testValues, false, $name, $data, $dataName);
    }
}
