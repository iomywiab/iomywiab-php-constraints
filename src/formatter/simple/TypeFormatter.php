<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: TypeFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

/** @noinspection PhpLackOfCohesionInspection */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\simple;

use iomywiab\iomywiab_php_constraints\formatter\AbstractFormatter;

/**
 * @psalm-immutable
 */
class TypeFormatter extends AbstractFormatter implements TypeFormatterInterface
{
    public const DEFAULT_ARRAY_STRING = 'array';
    public const DEFAULT_BOOLEAN_STRING = 'boolean';
    public const DEFAULT_FLOAT_STRING = 'double';
    public const DEFAULT_INTEGER_STRING = 'integer';
    public const DEFAULT_NULL_STRING = 'NULL';
    public const DEFAULT_OBJECT_STRING = 'object';
    public const DEFAULT_RESOURCE_STRING = 'resource';
    public const DEFAULT_RESOURCE_CLOSED_STRING = 'resource (closed)';
    public const DEFAULT_STRING_STRING = 'string';
    public const DEFAULT_UNKNOWN_STRING = 'unknown';
    public const DEFAULT_PREFIX = '';
    public const DEFAULT_POSTFIX = '';

    public readonly string $arrayString;
    public readonly string $booleanString;
    public readonly string $floatString;
    public readonly string $integerString;
    public readonly string $nullString;
    public readonly string $objectString;
    public readonly string $resourceString;
    public readonly string $closedResourceString;
    public readonly string $stringString;
    public readonly string $unknownString;

    /**
     * @param string|null $arrayString
     * @param string|null $booleanString
     * @param string|null $floatString
     * @param string|null $integerString
     * @param string|null $nullString
     * @param string|null $objectString
     * @param string|null $resourceString
     * @param string|null $closedResourceString
     * @param string|null $stringString
     * @param string|null $unknownString
     * @param string|null $prefix
     * @param string|null $postfix
     */
    public function __construct(
        ?string $arrayString = null,
        ?string $booleanString = null,
        ?string $floatString = null,
        ?string $integerString = null,
        ?string $nullString = null,
        ?string $objectString = null,
        ?string $resourceString = null,
        ?string $closedResourceString = null,
        ?string $stringString = null,
        ?string $unknownString = null,
        ?string $prefix = null,
        ?string $postfix = null
    ) {
        parent::__construct($prefix ?? self::DEFAULT_PREFIX, $postfix ?? self::DEFAULT_POSTFIX);
        \assert('' !== $arrayString);
        \assert('' !== $booleanString);
        \assert('' !== $floatString);
        \assert('' !== $integerString);
        \assert('' !== $nullString);
        \assert('' !== $objectString);
        \assert('' !== $resourceString);
        \assert('' !== $closedResourceString);
        \assert('' !== $stringString);
        \assert('' !== $unknownString);
        $this->arrayString = $arrayString ?? self::DEFAULT_ARRAY_STRING;
        $this->booleanString = $booleanString ?? self::DEFAULT_BOOLEAN_STRING;
        $this->floatString = $floatString ?? self::DEFAULT_FLOAT_STRING;
        $this->integerString = $integerString ?? self::DEFAULT_INTEGER_STRING;
        $this->nullString = $nullString ?? self::DEFAULT_NULL_STRING;
        $this->objectString = $objectString ?? self::DEFAULT_OBJECT_STRING;
        $this->resourceString = $resourceString ?? self::DEFAULT_RESOURCE_STRING;
        $this->closedResourceString = $closedResourceString ?? self::DEFAULT_RESOURCE_CLOSED_STRING;
        $this->stringString = $stringString ?? self::DEFAULT_STRING_STRING;
        $this->unknownString = $unknownString ?? self::DEFAULT_UNKNOWN_STRING;
    }

    /**
     * @inheritDoc
     */
    public function toString(mixed $value): string
    {
        $type = \gettype($value);
        $string = match ($type) {
            'array' => $this->arrayString . '(' . \count($value) . ')',
            'boolean' => $this->booleanString,
            'double' => $this->floatString,
            'integer' => $this->integerString,
            'NULL' => $this->nullString,
            'object' => $this->objectString,
            'resource' => $this->resourceString,
            'resource (closed)' => $this->closedResourceString,
            'string' => $this->stringString . '(' . \strlen($value) . ')',
            default => $this->unknownString
        };

        return $this->prefix . $string . $this->postfix;
    }


    /**
     * @inheritDoc
     */
    public function getArrayString(): string
    {
        return $this->arrayString;
    }

    /**
     * @inheritDoc
     */
    public function getBooleanString(): string
    {
        return $this->booleanString;
    }

    /**
     * @inheritDoc
     */
    public function getFloatString(): string
    {
        return $this->floatString;
    }

    /**
     * @inheritDoc
     */
    public function getIntegerString(): string
    {
        return $this->integerString;
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
    public function getObjectString(): string
    {
        return $this->objectString;
    }

    /**
     * @inheritDoc
     */
    public function getResourceString(): string
    {
        return $this->resourceString;
    }

    /**
     * @inheritDoc
     */
    public function getClosedResourceString(): string
    {
        return $this->closedResourceString;
    }

    /**
     * @inheritDoc
     */
    public function getStringString(): string
    {
        return $this->stringString;
    }

    /**
     * @inheritDoc
     */
    public function getUnknownString(): string
    {
        return $this->unknownString;
    }

    /**
     * @inheritDoc
     */
    public function withArrayString(string $arrayString): static
    {
        return new self(
            $arrayString,
            $this->booleanString,
            $this->floatString,
            $this->integerString,
            $this->nullString,
            $this->objectString,
            $this->resourceString,
            $this->closedResourceString,
            $this->stringString,
            $this->unknownString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withBooleanString(string $booleanString): static
    {
        return new self(
            $this->arrayString,
            $booleanString,
            $this->floatString,
            $this->integerString,
            $this->nullString,
            $this->objectString,
            $this->resourceString,
            $this->closedResourceString,
            $this->stringString,
            $this->unknownString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withFloatString(string $floatString): static
    {
        return new self(
            $this->arrayString,
            $this->booleanString,
            $floatString,
            $this->integerString,
            $this->nullString,
            $this->objectString,
            $this->resourceString,
            $this->closedResourceString,
            $this->stringString,
            $this->unknownString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withIntegerString(string $integerString): static
    {
        return new self(
            $this->arrayString,
            $this->booleanString,
            $this->floatString,
            $integerString,
            $this->nullString,
            $this->objectString,
            $this->resourceString,
            $this->closedResourceString,
            $this->stringString,
            $this->unknownString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withNullString(string $nullString): static
    {
        return new self(
            $this->arrayString,
            $this->booleanString,
            $this->floatString,
            $this->integerString,
            $nullString,
            $this->objectString,
            $this->resourceString,
            $this->closedResourceString,
            $this->stringString,
            $this->unknownString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withObjectString(string $objectString): static
    {
        return new self(
            $this->arrayString,
            $this->booleanString,
            $this->floatString,
            $this->integerString,
            $this->nullString,
            $objectString,
            $this->resourceString,
            $this->closedResourceString,
            $this->stringString,
            $this->unknownString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withResourceString(string $resourceString): static
    {
        return new self(
            $this->arrayString,
            $this->booleanString,
            $this->floatString,
            $this->integerString,
            $this->nullString,
            $this->objectString,
            $resourceString,
            $this->closedResourceString,
            $this->stringString,
            $this->unknownString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withClosedResourceString(string $closedResourceString): static
    {
        return new self(
            $this->arrayString,
            $this->booleanString,
            $this->floatString,
            $this->integerString,
            $this->nullString,
            $this->objectString,
            $this->resourceString,
            $closedResourceString,
            $this->stringString,
            $this->unknownString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withStringString(string $stringString): static
    {
        return new self(
            $this->arrayString,
            $this->booleanString,
            $this->floatString,
            $this->integerString,
            $this->nullString,
            $this->objectString,
            $this->resourceString,
            $this->closedResourceString,
            $stringString,
            $this->unknownString,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withUnknownString(string $unknownString): static
    {
        return new self(
            $this->arrayString,
            $this->booleanString,
            $this->floatString,
            $this->integerString,
            $this->nullString,
            $this->objectString,
            $this->resourceString,
            $this->closedResourceString,
            $this->stringString,
            $unknownString,
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
            $this->arrayString,
            $this->booleanString,
            $this->floatString,
            $this->integerString,
            $this->nullString,
            $this->objectString,
            $this->resourceString,
            $this->closedResourceString,
            $this->stringString,
            $this->unknownString,
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
            $this->arrayString,
            $this->booleanString,
            $this->floatString,
            $this->integerString,
            $this->nullString,
            $this->objectString,
            $this->resourceString,
            $this->closedResourceString,
            $this->stringString,
            $this->unknownString,
            $this->prefix,
            $postfix
        );
    }
}
