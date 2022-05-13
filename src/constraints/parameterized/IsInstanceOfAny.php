<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInstanceOfAny.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsArrayNotEmpty;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotEmpty;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsInstanceOfAny extends AbstractConstraint
{
    /**
     * IsInstanceOfAny constructor.
     * @param array<int,string> $classesAndInterfaces
     * @throws ConstraintViolationException
     */
    public function __construct(private /*readonly (but serializable)*/ array $classesAndInterfaces)
    {
        IsNotEmpty::assert($classesAndInterfaces);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->classesAndInterfaces, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->classesAndInterfaces, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param array<int,string>      $classesAndInterfaces
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        array $classesAndInterfaces,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        IsArrayNotEmpty::assert($classesAndInterfaces);

        foreach ($classesAndInterfaces as $classOrInterface) {
            if ($value instanceof $classOrInterface) {
                return true;
            }
        }

        if (null !== $errors) {
            $format = 'Instance of [%s] expected';
            $list = Format::toValueList($classesAndInterfaces);
            $errors[] = self::toErrorMessage($value, $valueName, $format, $list);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->classesAndInterfaces, $value, $valueName, $message);
    }

    /**
     * @param array<int,string>       $classesAndInterfaces
     * @param mixed            $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        array $classesAndInterfaces,
        mixed $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        IsArrayNotEmpty::assert($classesAndInterfaces);

        $errors = [];
        if (!static::isValid($classesAndInterfaces, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->classesAndInterfaces);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->classesAndInterfaces = \unserialize($data, ['allowed_class' => false]);
    }

    /**
     * @return array[]
     */
    public function __serialize(): array
    {
        return [$this->classesAndInterfaces];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->classesAndInterfaces = $data[0];
    }
}
