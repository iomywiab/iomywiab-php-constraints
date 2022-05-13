<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInArray.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsArrayNotEmpty;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsInArray extends AbstractConstraint
{
    public const DEFAULT_STRICT = true;

    /**
     * Instance constructor.
     * @param array $array
     * @param bool  $strict
     * @throws ConstraintViolationException
     */
    public function __construct(
        private /*readonly (but serializable)*/ array $array,
        private /*readonly (but serializable)*/ ?bool $strict = null
    ) {
        IsArrayNotEmpty::assert($array);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->array, $value, $this->strict, $valueName, $errors);
//        try {
//            return static::isValid($this->array, $value, $valueName, $this->strict, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param array                  $array
     * @param mixed                  $value
     * @param bool|null              $strict
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @throws ConstraintViolationException
    */
    public static function isValid(
        array $array,
        mixed $value,
        ?bool $strict = null,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        IsArrayNotEmpty::assert($array);

        if (\in_array($value, $array, ($strict ?? self::DEFAULT_STRICT))) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Member of array [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toValueList($array));
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->array, $value, $this->strict, $valueName, $message);
    }

    /**
     * @param array       $array
     * @param mixed       $value
     * @param bool|null   $strict
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        array $array,
        mixed $value,
        ?bool $strict = null,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($array, $value, $strict, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize([0 => $this->array, 1 => $this->strict]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $tmpArray = \unserialize($data, ['allowed_class' => false]);
        $this->array = $tmpArray[0];
        $this->strict = $tmpArray[1];
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [$this->array, $this->strict];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->array = $data[0];
        $this->strict = $data[1];
    }
}
