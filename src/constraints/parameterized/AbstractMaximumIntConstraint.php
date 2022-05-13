<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractMaximumIntConstraint.php
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
abstract class AbstractMaximumIntConstraint extends AbstractConstraint
{
    /**
     * IsArrayMaxCount constructor.
     * @param int $maximum
     * @throws ConstraintViolationException
     */
    public function __construct(private /*readonly (but serializable)*/ int $maximum)
    {
        IsGreaterOrEqual::assert(0, $maximum);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->maximum, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->maximum, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param int         $maximum
     * @param mixed       $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     */
    // @codeCoverageIgnoreStart
    public static function isValid(
        int $maximum,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        IsGreaterOrEqual::assert(0, $maximum);

        if (null !== $errors) {
            $errors[] = 'Constraint [' . static::class . '] is incomplete: Method [isValid] is not overloaded. Value '
                . Format::toDebugString($value) . ' cannot be verified against ' . Format::toDebugString(
                    $maximum
                );
        }
        return false;
    }
    // @codeCoverageIgnoreEnd

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->maximum, $value, $valueName, $message);
    }

    /**
     * @param int         $maximum
     * @param mixed       $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        int $maximum,
        mixed $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($maximum, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->maximum);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->maximum = \unserialize($data, ['allowed_class' => false]);
    }

    /**
     * @return int[]
     */
    public function __serialize(): array
    {
        return [$this->maximum];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->maximum = $data[0];
    }
}
