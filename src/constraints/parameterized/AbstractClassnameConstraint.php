<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractClassnameConstraint.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringNotEmpty;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * @psalm-immutable
 */
abstract class AbstractClassnameConstraint extends AbstractConstraint
{
    /**
     * Instance constructor.
     * @param string $className
     * @throws ConstraintViolationException
     */
    public function __construct(private /*readonly (but serializable)*/ string $className)
    {
        IsStringNotEmpty::assert($className);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->className, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->className, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

//    /**
//     *
//     * @param string      $className
//     * @param             $value
//     * @param string|null $valueName
//     * @param array|null  $errors
//     * @return bool
//     * @throws ConstraintViolationException
//     */
//    public static function isValid(string $className, $value, ?string $valueName = null, array &$errors = null): bool
//    {
//        IsStringNotEmpty::assert($className);
//
//        if (null !== $errors) {
//            $errors[] = 'Constraint [' . static::class . '] is incomplete: Method [isValid] is not overloaded. Value '
//                . Format::toDescription($value) . ' cannot be verified against ' . Format::toDescription($className);
//        }
//        return false;
//    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->className, $value, $valueName, $message);
    }

    /**
     * @param mixed       $value
     * @param string      $className
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        string $className,
        mixed $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($className, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->className);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->className = \unserialize($data, ['allowed_class' => false]);
    }

    /**
     * @return string[]
     */
    public function __serialize(): array
    {
        return [$this->className];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->className = $data[0];
    }
}
