<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ExtendedArrayFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\complex;

/**
 * ArrayFormatter -> ItemFormatter
 * MessageFormatter -> ArrayFormatter
 * ItemFormatter -> all formatters
 * @psalm-immutable
 */
class ExtendedArrayFormatter extends ArrayFormatter implements ExtendedArrayFormatterInterface
{
    public readonly ItemFormatterInterface $itemFormatter;

    /**
     * @param ItemFormatterInterface|null $itemFormatter
     * @param ArrayKeyFormatting|null     $arrayKeyFormatting
     * @param string|null                 $itemSeparator
     * @param string|null                 $itemAssigner
     * @param string|null                 $prefix
     * @param string|null                 $postfix
     */
    public function __construct(
        ?ItemFormatterInterface $itemFormatter = null,
        ?ArrayKeyFormatting $arrayKeyFormatting = null,
        ?string $itemSeparator = null,
        ?string $itemAssigner = null,
        ?string $prefix = null,
        ?string $postfix = null
    ) {
        parent::__construct($arrayKeyFormatting, $itemSeparator, $itemAssigner, $prefix, $postfix);
        $this->itemFormatter = $itemFormatter ?? new ItemFormatter();
    }

    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     */
    protected function itemToString(mixed $item): string
    {
        return $this->itemFormatter->toString($item);
    }

    /**
     * @return ItemFormatterInterface
     */
    public function getItemFormatter(): ItemFormatterInterface
    {
        return $this->itemFormatter;
    }

    /**
     * @inheritDoc
     */
    public function withItemFormatter(ItemFormatterInterface $itemFormatter): static
    {
        return new self(
            $itemFormatter,
            $this->arrayKeyFormatting,
            $this->itemSeparator,
            $this->itemAssigner,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function withArrayKeyFormatting(ArrayKeyFormatting $arrayKeyFormatting): static
    {
        return new self(
            $this->itemFormatter,
            $arrayKeyFormatting,
            $this->itemSeparator,
            $this->itemAssigner,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function withItemSeparator(string $itemSeparator): static
    {
        return new self(
            $this->itemFormatter,
            $this->arrayKeyFormatting,
            $itemSeparator,
            $this->itemAssigner,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function withItemAssigner(string $itemAssigner): static
    {
        return new self(
            $this->itemFormatter,
            $this->arrayKeyFormatting,
            $this->itemSeparator,
            $itemAssigner,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function withPrefix(string $prefix): static
    {
        return new self(
            $this->itemFormatter,
            $this->arrayKeyFormatting,
            $this->itemSeparator,
            $this->itemAssigner,
            $prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function withPostfix(string $postfix): static
    {
        return new self(
            $this->itemFormatter,
            $this->arrayKeyFormatting,
            $this->itemSeparator,
            $this->itemAssigner,
            $this->prefix,
            $postfix
        );
    }
}
