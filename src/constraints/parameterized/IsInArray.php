<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInArray.php
 * Class name...: IsInArray.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsArrayNotEmpty;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class Enum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsInArray extends AbstractConstraint
{
    public const DEFAULT_STRICT = true;

    /**
     * @var array
     */
    private $array;

    /**
     * @var bool
     */
    private $strict;

    /**
     * Instance constructor.
     * @param array $array
     * @param bool  $strict
     * @throws ConstraintViolationException
     */
    public function __construct(array $array, bool $strict = self::DEFAULT_STRICT)
    {
        IsArrayNotEmpty::assert($array);

        $this->array = $array;
        $this->strict = $strict;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->array, $value, $valueName, $this->strict, $errors);
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
     * @param array       $array
     * @param             $value
     * @param string|null $valueName
     * @param bool        $strict
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        array $array,
        $value,
        ?string $valueName = null,
        bool $strict = self::DEFAULT_STRICT,
        array &$errors = null
    ): bool {
        IsArrayNotEmpty::assert($array);

        if (in_array($value, $array, $strict)) {
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
        static::assert($this->array, $value, $valueName, $this->strict, $message);
    }

    /**
     * @param array       $array
     * @param             $value
     * @param string|null $valueName
     * @param bool        $strict
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        array $array,
        $value,
        ?string $valueName = null,
        bool $strict = self::DEFAULT_STRICT,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($array, $value, $valueName, $strict, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize([0 => $this->array, 1 => $this->strict]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $tmpArray = unserialize($data);
        $this->array = $tmpArray[0];
        $this->strict = $tmpArray[1];
    }

    public function __serialize(): array
    {
        return [$this->array, $this->strict];
    }

    public function __unserialize(array $data): void
    {
        $this->array = $data[0];
        $this->strict = $data[1];
    }

}