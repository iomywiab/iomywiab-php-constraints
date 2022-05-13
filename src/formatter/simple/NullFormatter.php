<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: NullFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\simple;

use iomywiab\iomywiab_php_constraints\formatter\AbstractFormatter;

/**
 * @psalm-immutable
 */
class NullFormatter extends AbstractFormatter implements NullFormatterInterface
{
    public const DEFAULT_NULL_STRING = 'null';
    public const DEFAULT_PREFIX = '';
    public const DEFAULT_POSTFIX = '';

    private readonly string $nullString;

    /**
     * @param string|null $nullString
     * @param string|null $prefix
     * @param string|null $postfix
     */
    public function __construct(
        ?string $nullString = null,
        ?string $prefix = null,
        ?string $postfix = null
    ) {
        parent::__construct($prefix ?? self::DEFAULT_PREFIX, $postfix ?? self::DEFAULT_POSTFIX);
        $this->nullString = $nullString ?? self::DEFAULT_NULL_STRING;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return $this->prefix . $this->nullString . $this->postfix;
    }

    /**
     * @inheritDoc
     */
    public function getNullString(): string
    {
        return $this->nullString;
    }

    /**
     * @inheritDoc
     */
    public function withPrefix(string $prefix): static
    {
        return new self(
            $this->nullString,
            $prefix,
            $this->postfix,
        );
    }

    /**
     * @inheritDoc
     */
    public function withPostfix(string $postfix): static
    {
        return new self(
            $this->nullString,
            $this->prefix,
            $postfix,
        );
    }

    /**
     * @inheritDoc
     */
    public function withNullString(string $nullString): static
    {
        return new self(
            $nullString,
            $this->prefix,
            $this->postfix,
        );
    }
}
