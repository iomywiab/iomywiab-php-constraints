<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsType.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsValidType;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * @psalm-immutable
 */
class IsType extends AbstractConstraint
{
    public const BOOL = IsValidType::BOOL;
    public const INT = IsValidType::INT;
    public const FLOAT = IsValidType::FLOAT;
    public const STRING = IsValidType::STRING;
    public const ARRAY = IsValidType::ARRAY;
    public const OBJECT = IsValidType::OBJECT;

    public const ALL_TYPES = IsValidType::ALL_TYPES;

    /**
     * Type constructor.
     * @param string $type
     * @throws ConstraintViolationException
     */
    public function __construct(private /*readonly (but serializable)*/ string $type)
    {
        IsValidType::assert($type);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->type, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->type, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param string                 $type
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(string $type, mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsValidType::assert($type);

        if ($type === \gettype($value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Type [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $type);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->type, $value, $valueName, $message);
    }

    /**
     * @param string      $type
     * @param mixed       $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(string $type, mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        $errors = [];
        if (!static::isValid($type, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->type);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->type = \unserialize($data, ['allowed_class' => false]);
    }

    /**
     * @return string[]
     */
    public function __serialize(): array
    {
        return [$this->type];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->type = $data[0];
    }
}
