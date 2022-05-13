<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ArrayFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\complex;

use iomywiab\iomywiab_php_constraints\formatter\AbstractFormatter;

/**
 * ArrayFormatter -> ItemFormatter
 * MessageFormatter -> ArrayFormatter
 * ItemFormatter -> all formatters
 * @psalm-immutable
 */
class ArrayFormatter extends AbstractFormatter implements ArrayFormatterInterface
{
    public const DEFAULT_ARRAY_KEY_FORMATTING = ArrayKeyFormatting::INCLUDE_KEYS_IF_NO_LIST;
    public const DEFAULT_ITEM_SEPARATOR = ',';
    public const DEFAULT_ITEM_ASSIGNER = '=>';
    public const DEFAULT_PREFIX = '[';
    public const DEFAULT_POSTFIX = ']';

    public readonly ArrayKeyFormatting $arrayKeyFormatting;
    public readonly string $itemSeparator;
    public readonly string $itemAssigner;

    /**
     * @param ArrayKeyFormatting|null $arrayKeyFormatting
     * @param string|null             $itemSeparator
     * @param string|null             $itemAssigner
     * @param string|null             $prefix
     * @param string|null             $postfix
     */
    public function __construct(
        ?ArrayKeyFormatting $arrayKeyFormatting = null,
        ?string $itemSeparator = null,
        ?string $itemAssigner = null,
        ?string $prefix = null,
        ?string $postfix = null
    ) {
        parent::__construct($prefix ?? self::DEFAULT_PREFIX, $postfix ?? self::DEFAULT_POSTFIX);
        $this->arrayKeyFormatting = $arrayKeyFormatting ?? self::DEFAULT_ARRAY_KEY_FORMATTING;
        $this->itemSeparator = $itemSeparator ?? self::DEFAULT_ITEM_SEPARATOR;
        $this->itemAssigner = $itemAssigner ?? self::DEFAULT_ITEM_ASSIGNER;
        \assert('' !== $this->itemSeparator);
        \assert('' !== $this->itemAssigner);
    }

    /**
     * @param mixed $item
     * @return string
     */
    protected function itemToString(mixed $item): string
    {
        return (string) $item;
    }

    /**
     * @inheritDoc
     */
    public function toString(array $array): string
    {
        if ([] === $array) {
            return '';
        }

        $string = $this->prefix;
        $arrayFormatting = $this->arrayKeyFormatting;
        $isFirst = true;
        $index = 0;
        foreach ($array as $key => $item) {
            if ($isFirst) {
                $isFirst = false;
            } else {
                $string .= $this->itemSeparator;
            }

            if ((ArrayKeyFormatting::INCLUDE_KEYS_IF_NO_LIST === $arrayFormatting) && ($index !== $key)) {
                $arrayFormatting = ArrayKeyFormatting::INCLUDE_KEYS;
            }
            if ($arrayFormatting === ArrayKeyFormatting::INCLUDE_KEYS) {
                $string .= $key . $this->itemAssigner;
            }
            $index++;

            $string .= $this->itemToString($item);
        }

        return $string . $this->postfix;
    }

    /**
     * @inheritDoc
     */
    public function getArrayKeyFormatting(): ArrayKeyFormatting
    {
        return $this->arrayKeyFormatting;
    }

    /**
     * @inheritDoc
     */
    public function getItemSeparator(): string
    {
        return $this->itemSeparator;
    }

    /**
     * @inheritDoc
     */
    public function getItemAssigner(): string
    {
        return $this->itemAssigner;
    }

    /**
     * @inheritDoc
     */
    public function withArrayKeyFormatting(ArrayKeyFormatting $arrayKeyFormatting): static
    {
        return new self(
            $arrayKeyFormatting,
            $this->itemSeparator,
            $this->itemAssigner,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withItemSeparator(string $itemSeparator): static
    {
        return new self(
            $this->arrayKeyFormatting,
            $itemSeparator,
            $this->itemAssigner,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withItemAssigner(string $itemAssigner): static
    {
        return new self(
            $this->arrayKeyFormatting,
            $this->itemSeparator,
            $itemAssigner,
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
            $this->arrayKeyFormatting,
            $this->itemSeparator,
            $this->itemAssigner,
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
            $this->arrayKeyFormatting,
            $this->itemSeparator,
            $this->itemAssigner,
            $this->prefix,
            $postfix
        );
    }
}
