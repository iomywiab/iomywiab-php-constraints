<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInRange.php
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
class IsInRange extends AbstractConstraint
{
    /**
     * Range constructor.
     * @param float|int $minimum
     * @param float|int $maximum
     * @throws ConstraintViolationException
     */
    public function __construct(
        private /*readonly (but serializable)*/ float|int $minimum,
        private /*readonly (but serializable)*/ float|int $maximum
    ) {
        IsGreaterOrEqual::assert($minimum, $maximum);
        IsLessOrEqual::assert($maximum, $minimum);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->minimum, $this->maximum, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->minimum, $this->maximum, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param float|int              $minimum
     * @param float|int              $maximum
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        float|int $minimum,
        float|int $maximum,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        IsGreaterOrEqual::assert($minimum, $maximum);
        IsLessOrEqual::assert($maximum, $minimum);

        if (\is_numeric($value) && ($minimum <= $value) && ($value <= $maximum)) {
            return true;
        }

        if (null !== $errors) {
            $minType = \is_int($minimum) ? 'd' : 'f';
            $maxType = \is_int($maximum) ? 'd' : 'f';
            $format = 'Numeric value in range [%' . $minType . ',%' . $maxType . '] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $minimum, $maximum);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->minimum, $this->maximum, $value, $valueName, $message);
    }

    /**
     * @param float|int   $minimum
     * @param float|int   $maximum
     * @param mixed       $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        float|int $minimum,
        float|int $maximum,
        mixed $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($minimum, $maximum, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize([0 => $this->minimum, 1 => $this->maximum]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $both = \unserialize($data, ['allowed_class' => false]);
        $this->minimum = $both[0];
        $this->maximum = $both[1];
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [$this->minimum, $this->maximum];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->minimum = $data[0];
        $this->maximum = $data[1];
    }
}
