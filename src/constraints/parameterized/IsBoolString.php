<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBoolString.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsArraySameTypeItemsOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsBoolString extends AbstractConstraint
{
    public const DEFAULT_BOOLEAN_STRINGS = [
        'true' => true,
        'false' => false,

        '1' => true,
        '0' => false,

        'on' => true,
        'off' => false,

        'yes' => true,
        'no' => false,

        'y' => true,
        'n' => false,

        'enabled' => true,
        'disabled' => false,

        'activated' => true,
        'deactivated' => false,

        'active' => true,
        'inactive' => false
    ];

    /**
     * Instance constructor.
     * @param array<string,bool>|null $lowercaseStrings name(string) => bool
     * @throws ConstraintViolationException
     */
    public function __construct(private /*readonly (but serializable)*/ ?array $lowercaseStrings = null)
    {
        IsArraySameTypeItemsOrNull::assert($lowercaseStrings);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($value, $this->lowercaseStrings, $valueName, $errors);
    }

    /**
     * @param mixed                   $value
     * @param array<string,bool>|null $lowercaseStrings
     * @param string|null             $valueName
     * @param array<int,string>|null  $errors
     * @return bool
     */
    public static function isValid(
        mixed $value,
        ?array $lowercaseStrings = null,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        $lowercaseStrings = $lowercaseStrings ?? self::DEFAULT_BOOLEAN_STRINGS;

//        if (is_string($value) && array_key_exists($value, $lowercaseStrings)) {
        if (\is_string($value) && isset($lowercaseStrings[$value])) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Boolean string expected. Valid values=[%s]';
            $errors[] = self::toErrorMessage(
                $value,
                $valueName,
                $format,
                Format::toValueList(array_keys($lowercaseStrings))
            );
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($value, $this->lowercaseStrings, $valueName, $message);
    }

    /**
     * @param mixed                   $value
     * @param array<string,bool>|null $lowercaseStrings
     * @param string|null             $valueName
     * @param string|null             $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        mixed $value,
        ?array $lowercaseStrings = null,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($value, $lowercaseStrings, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->lowercaseStrings);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->lowercaseStrings = \unserialize($data, ['allowed_class' => false]);
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [$this->lowercaseStrings];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->lowercaseStrings = $data[0];
    }
}
