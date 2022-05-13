<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringContaining.php
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
class IsStringContaining extends AbstractConstraint
{
    /**
     * Instance constructor.
     * @param string $subString
     * @throws ConstraintViolationException
     */
    public function __construct(private /*readonly (but serializable)*/ string $subString)
    {
        IsStringNotEmpty::assert($subString);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->subString, $value, $valueName, $errors);
    }

    /**
     * @param string                 $subString
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     */
    public static function isValid(
        string $subString,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if (\is_string($value) && (str_contains($value, $subString))) {
            return true;
        }

        if (null !== $errors) {
            $format = 'String containing [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $subString);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->subString, $value, $valueName, $message);
    }

    /**
     * @param string      $subString
     * @param mixed       $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        string $subString,
        mixed $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($subString, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->subString);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->subString = \unserialize($data, ['allowed_class' => false]);
    }

    /**
     * @return string[]
     */
    public function __serialize(): array
    {
        return [$this->subString];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->subString = $data[0];
    }
}
