<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: BooleanFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\scalar;

use iomywiab\iomywiab_php_constraints\formatter\AbstractFormatter;

/**
 * @psalm-immutable
 */
class BooleanFormatter extends AbstractFormatter implements BooleanFormatterInterface
{
    public const DEFAULT_TRUE_STRING = 'true';
    public const DEFAULT_FALSE_STRING = 'false';
    public const DEFAULT_PREFIX = '';
    public const DEFAULT_POSTFIX = '';

    public readonly string $trueString;
    public readonly string $falseString;

    /**
     * @param string|null $trueString
     * @param string|null $falseString
     * @param string|null $prefix
     * @param string|null $postfix
     */
    public function __construct(
        ?string $trueString = null,
        ?string $falseString = null,
        ?string $prefix = null,
        ?string $postfix = null
    ) {
        parent::__construct($prefix ?? self::DEFAULT_PREFIX, $postfix ?? self::DEFAULT_POSTFIX);
        \assert('' !== $trueString);
        \assert('' !== $falseString);
        $this->trueString = $trueString ?? self::DEFAULT_TRUE_STRING;
        $this->falseString = $falseString ?? self::DEFAULT_FALSE_STRING;
        \assert($this->trueString !== $this->falseString);
    }

    /**
     * @inheritDoc
     */
    public function toString(bool $boolean): string
    {
        return $this->prefix . ($boolean ? $this->trueString : $this->falseString) . $this->postfix;
    }

    /**
     * @inheritDoc
     */
    public function getTrueString(): string
    {
        return $this->trueString;
    }

    /**
     * @inheritDoc
     */
    public function getFalseString(): string
    {
        return $this->falseString;
    }

    /**
     * @inheritDoc
     */
    public function withTrueString(string $trueString): static
    {
        return new self(
            $trueString,
            $this->falseString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withFalseString(string $falseString): static
    {
        return new self(
            $this->trueString,
            $falseString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withPrefix(string $prefix): static
    {
        return new self(
            $this->trueString,
            $this->falseString,
            $prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withPostfix(string $postfix): static
    {
        return new self(
            $this->trueString,
            $this->falseString,
            $this->prefix,
            $postfix
        );
    }
}
