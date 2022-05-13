<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter;

/**
 * @psalm-immutable
 */
abstract class AbstractFormatter implements FormatterInterface
{
    /**
     * @param string $prefix
     * @param string $postfix
     */
    public function __construct(
        public readonly string $prefix,
        public readonly string $postfix
    ) {
        // no code
    }

    /**
     * @inheritDoc
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @inheritDoc
     */
    public function getPostfix(): string
    {
        return $this->postfix;
    }
}
