<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: LengthFormatter.php
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
class LengthFormatter extends AbstractFormatter implements LengthFormatterInterface
{
    public const DEFAULT_MAX_LENGTH = 0;
    public const DEFAULT_APPENDIX_STRING = '...';
    public const DEFAULT_PREFIX = '';
    public const DEFAULT_POSTFIX = '';

    private readonly string $appendixString;
    private readonly int $appendixLength;
    private readonly int $maxLength;

    /**
     * @param int|null    $maxLength
     * @param string|null $appendixString
     * @param string|null $prefix
     * @param string|null $postfix
     */
    public function __construct(
        ?int $maxLength = null,
        ?string $appendixString = null,
        ?string $prefix = null,
        ?string $postfix = null
    ) {
        parent::__construct($prefix ?? self::DEFAULT_PREFIX, $postfix ?? self::DEFAULT_POSTFIX);
        $this->maxLength = $maxLength ?? self::DEFAULT_MAX_LENGTH;
        $this->appendixString = $appendixString ?? self::DEFAULT_APPENDIX_STRING;
        $this->appendixLength = \strlen($this->appendixString);
        \assert((0 === $this->maxLength) || ($this->maxLength > $this->appendixLength));
    }

    /**
     * @inheritDoc
     */
    public function toString(string $string): string
    {
        if (0 === $this->maxLength) {
            return $string;
        }

        $length = \strlen($string);
        return ($length <= $this->maxLength)
            ? $string
            : \substr($string, 0, $this->maxLength - $this->appendixLength) . $this->appendixString;
    }

    /**
     * @inheritDoc
     */
    public function getAppendixString(): string
    {
        return $this->appendixString;
    }

    /**
     * @inheritDoc
     */
    public function getAppendixLength(): int
    {
        return $this->appendixLength;
    }

    /**
     * @inheritDoc
     */
    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    /**
     * @inheritDoc
     */
    public function withAppendixString(string $appendixString): static
    {
        return new self(
            $this->maxLength,
            $appendixString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withMaxLength(int $maxLength): static
    {
        return new self(
            $maxLength,
            $this->appendixString,
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
            $this->maxLength,
            $this->appendixString,
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
            $this->maxLength,
            $this->appendixString,
            $this->prefix,
            $postfix
        );
    }
}
