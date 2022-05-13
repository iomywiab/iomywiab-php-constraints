<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsLess.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * @psalm-immutable
 */
class IsLess extends AbstractConstraint
{
    /**
     * Maximum constructor.
     * @param float|int $maximum
     * @throws ConstraintViolationException
     */
    public function __construct(private /*readonly (but serializable)*/ float|int $maximum)
    {
        // no code
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
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
     * @param float|int              $maximum
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        float|int $maximum,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if (\is_numeric($value) && ($value < $maximum)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Numeric value smaller than maximum [%' . (\is_int($maximum) ? 'd' : 'f') . '] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $maximum);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->maximum, $value, $valueName, $message);
    }

    /**
     * @param float|int   $maximum
     * @param mixed       $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        float|int $maximum,
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
     * @return array
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
