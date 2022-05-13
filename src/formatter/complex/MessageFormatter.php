<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: MessageFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\complex;

use iomywiab\iomywiab_php_constraints\formatter\AbstractFormatter;

/**
 * @psalm-immutable
 */
class MessageFormatter extends AbstractFormatter implements MessageFormatterInterface
{
    public const DEFAULT_PREFIX = '';
    public const DEFAULT_POSTFIX = '';

    public readonly ArrayFormatterInterface $arrayFormatter;

    /**
     * @param ArrayFormatter|null $arrayFormatter
     * @param string|null         $prefix
     * @param string|null         $postfix
     */
    public function __construct(
        ?ArrayFormatterInterface $arrayFormatter = null,
        ?string $prefix = null,
        ?string $postfix = null
    ) {
        parent::__construct($prefix ?? self::DEFAULT_PREFIX, $postfix ?? self::DEFAULT_POSTFIX);
        $this->arrayFormatter = $arrayFormatter ?? new ArrayFormatter();
    }

    /**
     * @inheritDoc
     */
    public function toString(string $message, ?array $values = null): string
    {
        $dot = (('' !== $message) && !\str_ends_with($message, '.')) ? '.' : '';
        $space = ('' !== $message) && (null !== $values) && ([] !== $values) ? ' ' : '';
        $valueArray = (null === $values) || ([] === $values) ? '' : $this->arrayFormatter->toString($values);

        return $this->prefix . $message . $dot . $space . $valueArray . $this->postfix;
    }

    /**
     * @inheritDoc
     */
    public function getArrayFormatter(): ArrayFormatterInterface
    {
        return $this->arrayFormatter;
    }

    /**
     * @inheritDoc
     */
    public function withArrayFormatter(ArrayFormatterInterface $arrayFormatter): static
    {
        return new self(
            $arrayFormatter,
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
            $this->arrayFormatter,
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
            $this->arrayFormatter,
            $this->prefix,
            $postfix
        );
    }
}
