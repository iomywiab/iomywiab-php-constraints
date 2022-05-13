<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: FloatFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\scalar;

/**
 * @psalm-immutable
 */
class FloatFormatter extends AbstractNumberFormatter implements FloatFormatterInterface
{
    // Defaults are compatible to PHP conversion
    public const DEFAULT_PLUS_PREFIX = '';
    public const DEFAULT_PLUS_POSTFIX = '';
    public const DEFAULT_MINUS_PREFIX = '-';
    public const DEFAULT_MINUS_POSTFIX = '';
    public const DEFAULT_INTEGER_POSTFIX = '.0';
    public const DEFAULT_PREFIX = '';
    public const DEFAULT_POSTFIX = '';

    public readonly string $integerPostfix;

    /**
     * @param string|null $plusPrefix
     * @param string|null $minusPrefix
     * @param string|null $plusPostfix
     * @param string|null $minusPostfix
     * @param string|null $integerPostfix
     * @param string|null $prefix
     * @param string|null $postfix
     */
    public function __construct(
        ?string $plusPrefix = null,
        ?string $minusPrefix = null,
        ?string $plusPostfix = null,
        ?string $minusPostfix = null,
        ?string $integerPostfix = null,
        ?string $prefix = null,
        ?string $postfix = null
    ) {
        parent::__construct(
            $plusPrefix ?? self::DEFAULT_PLUS_PREFIX,
            $plusPostfix ?? self::DEFAULT_PLUS_POSTFIX,
            $minusPrefix ?? self::DEFAULT_MINUS_PREFIX,
            $minusPostfix ?? self::DEFAULT_MINUS_POSTFIX,
            $prefix ?? self::DEFAULT_PREFIX,
            $postfix ?? self::DEFAULT_POSTFIX,
        );
        $this->integerPostfix = $integerPostfix ?? self::DEFAULT_INTEGER_POSTFIX;
    }

    /**
     * @inheritDoc
     */
    public function toString(float $float): string
    {
        if (0.0 === $float) {
            $numberPrefix = '';
            $numberPostfix = '';
            $intPostfix = $this->integerPostfix;
        } else {
            if (0.0 > $float) {
                $numberPrefix = $this->minusPrefix;
                $numberPostfix = $this->minusPostfix;
                /** @noinspection CallableParameterUseCaseInTypeContextInspection */
                $float = \abs($float);
            } else {
                $numberPrefix = $this->plusPrefix;
                $numberPostfix = $this->plusPostfix;
            }
            /** @noinspection TypeUnsafeComparisonInspection */
            $intPostfix = ($float == (int)$float) ? $this->integerPostfix : '';
        }

        return $this->prefix . $numberPrefix . $float . $intPostfix . $numberPostfix . $this->postfix;
    }

    /**
     * @inheritDoc
     */
    public function getIntegerPostfix(): string
    {
        return $this->integerPostfix;
    }

    /**
     * @inheritDoc
     */
    public function withIntegerPostfix(string $integerPostfix): static
    {
        return new self(
            $this->plusPrefix,
            $this->minusPrefix,
            $this->plusPostfix,
            $this->minusPostfix,
            $integerPostfix,
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
            $this->plusPrefix,
            $this->minusPrefix,
            $this->plusPostfix,
            $this->minusPostfix,
            $this->integerPostfix,
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
            $this->plusPrefix,
            $this->minusPrefix,
            $this->plusPostfix,
            $this->minusPostfix,
            $this->integerPostfix,
            $this->prefix,
            $postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withPlusPrefix(string $plusPrefix): static
    {
        return new self(
            $plusPrefix,
            $this->minusPrefix,
            $this->plusPostfix,
            $this->minusPostfix,
            $this->integerPostfix,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withPlusPostfix(string $plusPostfix): static
    {
        return new self(
            $this->plusPrefix,
            $this->minusPrefix,
            $plusPostfix,
            $this->minusPostfix,
            $this->integerPostfix,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withMinusPrefix(string $minusPrefix): static
    {
        return new self(
            $this->plusPrefix,
            $minusPrefix,
            $this->plusPostfix,
            $this->minusPostfix,
            $this->integerPostfix,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withMinusPostfix(string $minusPostfix): static
    {
        return new self(
            $this->plusPrefix,
            $this->minusPrefix,
            $this->plusPostfix,
            $minusPostfix,
            $this->integerPostfix,
            $this->prefix,
            $this->postfix
        );
    }
}
