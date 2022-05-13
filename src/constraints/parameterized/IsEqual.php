<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsEqual.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsEqual extends AbstractConstraint
{
    public const DEFAULT_STRICT = true;

    /**
     * Maximum constructor.
     * @param mixed $expected
     * @param bool  $strict
     */
    public function __construct(
        private /*readonly (but serializable)*/ mixed $expected,
        private /*readonly (but serializable)*/ ?bool $strict = null
    ) {
        // no code
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->expected, $value, $this->strict, $valueName, $errors);
    }

    /**
     * @param mixed       $expected
     * @param mixed       $actual
     * @param string|null $valueName
     * @param bool        $strict
     * @param array<int,string>|null  $errors
     * @return bool
     */
    public static function isValid(
        mixed $expected,
        mixed $actual,
        bool $strict = null,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        $strict = $strict ?? self::DEFAULT_STRICT;

        if ($strict && ($expected === $actual)) {
            return true;
        }

        /** @noinspection TypeUnsafeComparisonInspection */
        if (!$strict && ($expected == $actual)) {
            return true;
        }

        if (null !== $errors) {
            $expected = Format::toDebugString($expected);
            $format = 'Expected value [%s] is not equal to actual';
            $errors[] = self::toErrorMessage($actual, $valueName, $format, $expected);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->expected, $value, $this->strict, $valueName, $message);
    }

    /**
     * @param mixed       $expected
     * @param mixed       $actual
     * @param string|null $valueName
     * @param bool        $strict
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        mixed $expected,
        mixed $actual,
        bool $strict = null,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($expected, $actual, $strict, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $actual, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize([$this->expected, $this->strict]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $array = \unserialize($data, ['allowed_class' => false]);
        $this->expected = $array[0];
        $this->strict = $array[1];
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [$this->expected, $this->strict];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->expected = $data[0];
        $this->strict = $data[1];
    }
}
