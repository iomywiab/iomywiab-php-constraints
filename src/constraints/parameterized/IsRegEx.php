<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsRegEx.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
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
class IsRegEx extends AbstractConstraint
{
    /**
     * Instance constructor.
     * @param string $regEx
     * @throws ConstraintViolationException
     */
    public function __construct(private /*readonly (but serializable)*/ string $regEx)
    {
        IsStringNotEmpty::assert($regEx);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->regEx, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->regEx, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param string                 $regEx
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(string $regEx, mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsStringNotEmpty::assert($regEx);

        if (\is_string($value) && (1 === \preg_match($regEx, $value))) {
            return true;
        }

        if (null !== $errors) {
            $format = 'String matching [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $regEx);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->regEx, $value, $valueName, $message);
    }

    /**
     * @param string      $regEx
     * @param mixed       $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(string $regEx, mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        $errors = [];
        if (!static::isValid($regEx, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->regEx);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->regEx = \unserialize($data, ['allowed_class' => false]);
    }

    /**
     * @return string[]
     */
    public function __serialize(): array
    {
        return [$this->regEx];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->regEx = $data[0];
    }
}
