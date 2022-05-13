<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsKeyExists.php
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
class IsKeyExists extends AbstractConstraint
{
    /**
     * Instance constructor.
     * @param array $array
     */
    public function __construct(private /*readonly (but serializable)*/ array $array)
    {
        // no code
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->array, $value, $valueName, $errors);
    }

    /**
     * @param array                  $array
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     */
    public static function isValid(array $array, mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        if ((\is_int($value) || \is_string($value)) && (isset($array[$value]) || \array_key_exists($value, $array))) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Key for array %s expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toString($array));
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->array, $value, $valueName, $message);
    }

    /**
     * @param array       $array
     * @param mixed       $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(array $array, mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        $errors = [];
        if (!static::isValid($array, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->array);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->array = \unserialize($data, ['allowed_class' => false]);
    }

    /**
     * @return array[]
     */
    public function __serialize(): array
    {
        return [$this->array];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->array = $data[0];
    }
}
