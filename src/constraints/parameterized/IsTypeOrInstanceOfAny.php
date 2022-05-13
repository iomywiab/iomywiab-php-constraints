<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOrInstanceOfAny.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotEmpty;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsValidTypeArray;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsTypeOrInstanceOfAny extends AbstractConstraint
{
    /**
     * IsTypeOrInstanceOfAny constructor.
     * @param array<int,string> $types
     * @param array<int,string>  $classesAndInterfaces
     * @throws ConstraintViolationException
     */
    public function __construct(
        private /*readonly (but serializable)*/ array $types,
        private /*readonly (but serializable)*/ array $classesAndInterfaces
    ) {
        IsValidTypeArray::assert($types);
        IsNotEmpty::assert($classesAndInterfaces);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->types, $this->classesAndInterfaces, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->types, $this->classesAndInterfaces, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), 0, $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param array<int,string>      $types
     * @param array<int,string>      $classesAndInterfaces
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        array $types,
        array $classesAndInterfaces,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if (IsTypeOfAny::isValid($types, $value)) {
            return true;
        }
        if (IsInstanceOfAny::isValid($classesAndInterfaces, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Type [%s] or instance of [%s] expected';
            $typeList = Format::toValueList($types);
            $instanceList = Format::toValueList($classesAndInterfaces);
            $errors[] = self::toErrorMessage($value, $valueName, $format, $typeList, $instanceList);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->types, $this->classesAndInterfaces, $value, $valueName, $message);
    }

    /**
     * @param array<int,string> $types
     * @param array<int,string> $classesAndInterfaces
     * @param mixed             $value
     * @param string|null       $valueName
     * @param string|null       $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        array $types,
        array $classesAndInterfaces,
        mixed $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($types, $classesAndInterfaces, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize([$this->types, $this->classesAndInterfaces]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $tmp = \unserialize($data, ['allowed_class' => false]);
        $this->types = $tmp[0];
        $this->classesAndInterfaces = $tmp[1];
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [$this->types, $this->classesAndInterfaces];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->types = $data[0];
        $this->classesAndInterfaces = $data[1];
    }
}
