<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ObjectFormatter.php
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
class ObjectFormatter extends AbstractFormatter implements ObjectFormatterInterface
{
    public const DEFAULT_VALUE_PREFIX = ':[';
    public const DEFAULT_VALUE_POSTFIX = ']';
    public const DEFAULT_PREFIX = '';
    public const DEFAULT_POSTFIX = '';

    public readonly string $valuePrefix;
    public readonly string $valuePostfix;

    /**
     * @param string|null $valuePrefix
     * @param string|null $valuePostfix
     * @param string|null $prefix
     * @param string|null $postfix
     */
    public function __construct(
        ?string $valuePrefix = null,
        ?string $valuePostfix = null,
        ?string $prefix = null,
        ?string $postfix = null
    ) {
        parent::__construct($prefix ?? self::DEFAULT_PREFIX, $postfix ?? self::DEFAULT_POSTFIX);
        $this->valuePrefix = $valuePrefix ?? self::DEFAULT_VALUE_PREFIX;
        $this->valuePostfix = $valuePostfix ?? self::DEFAULT_VALUE_POSTFIX;
    }

    /**
     * @inheritDoc
     */
    public function toString(object $object): string
    {
        try {
            $class = $this->toShortClassName($object);

            if (\method_exists($object, '__toString')) {
                /** @var string $value */
                $value = $object->__toString();
            } elseif ($object instanceof \DateTime || $object instanceof \DateTimeImmutable) {
                $value = $object->format('c');
            } else {
                $value = '';
            }
        } catch (\ReflectionException) {
            $class = 'unknown-object';
            $value = 'unknown-value';
        }

        if ('' === $value) {
            $valPrefix = '';
            $valPostfix = '';
        } else {
            $valPrefix = $this->valuePrefix;
            $valPostfix = $this->valuePostfix;
        }
        return $this->prefix . $class . $valPrefix . $value . $valPostfix . $this->postfix;
    }

    /**
     * @inheritDoc
     */
    public function toShortClassName(object|string $object): string
    {
        return (new \ReflectionClass($object))->getShortName();
    }

    /**
     * @inheritDoc
     */
    public function toClassName(object|string $object): string
    {
        return (new \ReflectionClass($object))->getName();
    }

    /**
     * @return string
     */
    public function getValuePrefix(): string
    {
        return $this->valuePrefix;
    }

    /**
     * @return string
     */
    public function getValuePostfix(): string
    {
        return $this->valuePostfix;
    }

    /**
     * @param string $valuePrefix
     * @return static
     */
    public function withValuePrefix(string $valuePrefix): static
    {
        return new self(
            $valuePrefix,
            $this->valuePostfix,
            $this->prefix,
            $this->postfix,
        );
    }

    /**
     * @param string $valuePostfix
     * @return static
     */
    public function withValuePostfix(string $valuePostfix): static
    {
        return new self(
            $this->valuePrefix,
            $valuePostfix,
            $this->prefix,
            $this->postfix,
        );
    }

    /**
     * @param string $prefix
     * @return static
     */
    public function withPrefix(string $prefix): static
    {
        return new self(
            $this->valuePrefix,
            $this->valuePostfix,
            $prefix,
            $this->postfix,
        );
    }

    /**
     * @param string $postfix
     * @return static
     */
    public function withPostfix(string $postfix): static
    {
        return new self(
            $this->valuePrefix,
            $this->valuePostfix,
            $this->prefix,
            $postfix,
        );
    }
}
