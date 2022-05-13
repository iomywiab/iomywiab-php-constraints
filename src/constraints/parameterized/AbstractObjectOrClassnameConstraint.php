<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractObjectOrClassnameConstraint.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:43
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
abstract class AbstractObjectOrClassnameConstraint extends AbstractConstraint
{
    /**
     * IsArrayMaxCount constructor.
     * @param object|string $objectOrClass
     * @throws ConstraintViolationException
     */
    public function __construct(private /*readonly (but serializable)*/ object|string $objectOrClass)
    {
        // no code
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->objectOrClass, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->objectOrClass, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param object|class-string       $objectOrClass
     * @param mixed       $value
     * @param string|null $valueName
     * @param array<int,string>|null  $errors
     * @return bool
     */
    // @codeCoverageIgnoreStart
    public static function isValid(
        object|string $objectOrClass,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if (null !== $errors) {
            $errors[] = 'Constraint [' . static::class . '] is incomplete: Method [isValid] is not overloaded. Value '
                . Format::toDebugString($value) . ' cannot be verified against '
                . Format::toDebugString($objectOrClass);
        }
        return false;
    }
    // @codeCoverageIgnoreEnd

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->objectOrClass, $value, $valueName, $message);
    }

    /**
     * @param object|string $objectOrClass
     * @param mixed         $value
     * @param string|null   $valueName
     * @param string|null   $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        object|string $objectOrClass,
        mixed $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($objectOrClass, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->objectOrClass);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->objectOrClass = \unserialize($data, ['allowed_class' => true]);
    }


    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [$this->objectOrClass];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->objectOrClass = $data[0];
    }
}
