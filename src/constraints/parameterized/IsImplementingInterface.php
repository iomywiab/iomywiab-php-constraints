<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsImplementingInterface.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use Exception;
use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringNotEmpty;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Checks for instance only. IsInstanceOf is more flexible and probably faster
 * @psalm-immutable
 */
class IsImplementingInterface extends AbstractConstraint
{
    /**
     * IsImplementingInterface constructor.
     * @param string $interfaceName
     * @throws ConstraintViolationException
     */
    public function __construct(private /*readonly (but serializable)*/string $interfaceName)
    {
        IsStringNotEmpty::assert($interfaceName);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->interfaceName, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->interfaceName, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param string      $interfaceName
     * @param mixed       $value
     * @param string|null $valueName
     * @param array<int,string>|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     * @noinspection PhpUnusedLocalVariableInspection
     */
    public static function isValid(
        string $interfaceName,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        IsStringNotEmpty::assert($interfaceName);

        if (\is_object($value) || \is_string($value)) {
            $value = [$value];
        }

        if (\is_array($value) && ([] !== $value)) {
            $isValid = true;
            try {
                foreach ($value as $item) {
                    if (
                        !(\is_string($item) || \is_object($item)) || !\in_array(
                            $interfaceName,
                            class_implements($item),
                            true
                        )
                    ) {
                        $isValid = false;
                        break;
                    }
                }
            } /** @noinspection BadExceptionsProcessingInspection */ catch (Exception $ignore) {
                $isValid = false;
            }
            if ($isValid) {
                return true;
            }
        }

        if (null !== $errors) {
            if (\is_array($value) && ([] !== $value)) {
                foreach ($value as $item) {
                    try {
                        if (
                            !(\is_string($item) || \is_object($item)) || !\in_array(
                                $interfaceName,
                                class_implements($item),
                                true
                            )
                        ) {
                            $format = 'Class implementing interface [%s] expected';
                            $errors[] = self::toErrorMessage($value, $valueName, $format, $interfaceName);
                        }
                    } /** @noinspection BadExceptionsProcessingInspection */ catch (Exception $ignore) {
                        $format = 'Exception when checking interfaces';
                        $errors[] = self::toErrorMessage($value, $valueName, $format);
                    }
                }
            } else {
                $format = 'Class implementing interface [%s] expected';
                $errors[] = self::toErrorMessage($value, $valueName, $format, $interfaceName);
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->interfaceName, $value, $valueName, $message);
    }

    /**
     * @param string      $interfaceName
     * @param mixed             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        string $interfaceName,
        mixed $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($interfaceName, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->interfaceName);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->interfaceName = \unserialize($data, ['allowed_class' => false]);
    }

    /**
     * @return string[]
     */
    public function __serialize(): array
    {
        return [$this->interfaceName];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->interfaceName = $data[0];
    }
}
