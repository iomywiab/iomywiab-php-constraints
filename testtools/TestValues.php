<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: TestValues.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-05 14:44:48
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_testtools;

/**
 */
class TestValues extends StandardTestValues
{
    /**
     * @param array<int,mixed> $validSamples user defined valid samples which get tested
     *                                       in addition to the standard values
     * @param array<int,mixed> $invalidSamples user defined invalid samples which get tested
     *                                         in addition to the standard values
     */
    public function __construct(
        public readonly array $validSamples,
        public readonly array $invalidSamples
    ) {
        // no code
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function isValidSample(mixed $value): bool
    {
        return \in_array($value, $this->validSamples, true);
    }
}
