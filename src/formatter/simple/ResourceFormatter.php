<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ResourceFormatter.php
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
class ResourceFormatter extends AbstractFormatter implements ResourceFormatterInterface
{
    public const DEFAULT_ID_PREFIX = '(id=';
    public const DEFAULT_ID_POSTFIX = ')';
    public const DEFAULT_PREFIX = '';
    public const DEFAULT_POSTFIX = '';

    public readonly string $idPrefix;
    public readonly string $idPostfix;

    /**
     * @param string|null $idPrefix
     * @param string|null $idPostfix
     * @param string|null $prefix
     * @param string|null $postfix
     */
    public function __construct(
        ?string $idPrefix = null,
        ?string $idPostfix = null,
        ?string $prefix = null,
        ?string $postfix = null
    ) {
        parent::__construct($prefix ?? self::DEFAULT_PREFIX, $postfix ?? self::DEFAULT_POSTFIX);
        $this->idPrefix = $idPrefix ?? self::DEFAULT_ID_PREFIX;
        $this->idPostfix = $idPostfix ?? self::DEFAULT_ID_POSTFIX;
    }

    /**
     * @inheritDoc
     */
    public function toString(mixed $resource): string
    {
        $type = \get_resource_type($resource);
        $resId = \get_resource_id($resource);
        return $this->prefix . $type . $this->idPrefix . $resId . $this->idPostfix . $this->postfix;
    }

    /**
     * @return string
     */
    public function getIdPrefix(): string
    {
        return $this->idPrefix;
    }

    /**
     * @return string
     */
    public function getIdPostfix(): string
    {
        return $this->idPostfix;
    }

    /**
     * @param string $idPrefix
     * @return static
     */
    public function withIdPrefix(string $idPrefix): static
    {
        return new self(
            $idPrefix,
            $this->idPostfix,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @param string $idPostfix
     * @return static
     */
    public function withIdPostfix(string $idPostfix): static
    {
        return new self(
            $this->idPrefix,
            $idPostfix,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @param string $prefix
     * @return static
     */
    public function withPrefix(string $prefix): static
    {
        return new self(
            $this->idPrefix,
            $this->idPostfix,
            $prefix,
            $this->postfix
        );
    }

    /**
     * @param string $postfix
     * @return static
     */
    public function withPostfix(string $postfix): static
    {
        return new self(
            $this->idPrefix,
            $this->idPostfix,
            $this->prefix,
            $postfix
        );
    }
}
