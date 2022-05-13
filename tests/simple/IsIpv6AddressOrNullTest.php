<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsIpv6AddressOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 23:30:43
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsIpv6AddressOrNull;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsIpv6AddressOrNullTest extends ConstraintTestCase
{
    /**
     * @param mixed $name
     * @param array $data
     * @param mixed $dataName
     * @noinspection SpellCheckingInspection
     */
    public function __construct(
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        $validSamples = [
            null,
            '2001:0db8:85a3:08d3:1319:8a2e:0370:7344',
            '2001:db8:0:8d3:0:8a2e:70:7344',
            '2001:db8:0:0:0:0:1428:57ab',
            '2001:db8::1428:57ab',
            '2001:0db8:0:0:8d3:0:0:0',
            '2001:db8:0:0:8d3::',
            '2001:db8::8d3:0:0:0',
            '::ffff:127.0.0.1',
            '::ffff:7f00:1',
        ];
        $testValues = new TestValues($validSamples, ['2001:0db8:85a3:08d3:1319:8a2e:0370:734z']);

        parent::__construct(new IsIpv6AddressOrNull(), $testValues, false, $name, $data, $dataName);
    }
}
