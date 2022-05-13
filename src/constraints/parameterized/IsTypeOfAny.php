<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOfAny.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsValidTypeArray;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsTypeOfAny extends AbstractConstraint
{
    /**
     * Type constructor.
     * @param array<int,string> $types
     * @throws ConstraintViolationException
     */
    public function __construct(private /*readonly (but serializable)*/ array $types)
    {
        IsValidTypeArray::assert($types);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->types, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->types, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param array<int,string>      $types
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(array $types, mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsValidTypeArray::assert($types);

        $type = \gettype($value);
        if (\in_array($type, $types, true)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Type [%s] expected';
            $list = Format::toValueList($types);
            $errors[] = self::toErrorMessage($value, $valueName, $format, $list);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->types, $value, $valueName, $message);
    }

    /**
     * @param array<int,string>    $types
     * @param mixed       $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(array $types, mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        $errors = [];
        if (!static::isValid($types, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->types);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->types = \unserialize($data, ['allowed_class' => false]);
    }

    /**
     * @return string[][]
     */
    public function __serialize(): array
    {
        return [$this->types];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->types = $data[0];
    }
}
