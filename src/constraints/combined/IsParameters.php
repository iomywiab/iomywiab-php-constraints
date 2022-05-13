<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsParameters.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\combined;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\formatter\complex\Format;
use iomywiab\iomywiab_php_constraints\interfaces\ConstraintInterface;

/**
 * @psalm-immutable
 */
class IsParameters extends AbstractConstraint
{
    public const ALLOW_OTHERS = true;
    public const DEFINED_ONLY = false;

    /**
     * @param bool  $allowUnknownParameters
     * @param array $pattern
     */
    public function __construct(
        private /*readonly (but serializable)*/ array $pattern,
        private /*readonly (but serializable)*/ bool $allowUnknownParameters = false
    ) {
        // no code
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->pattern, $value, $this->allowUnknownParameters, $valueName, $errors);
//        try {
//            return static::isValid($this->pattern, $value, $valueName, $this->allowUnknownParameters, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param array                  $pattern
     * @param mixed                  $value
     * @param bool                   $allowUnknownParameters
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        array $pattern,
        mixed $value,
        bool $allowUnknownParameters = null,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if (empty($value) && ([] === $pattern)) {
            return true;
        }
        $allowUnknownParameters = $allowUnknownParameters ?? false;

        $isValid = false;
        if (null === $value) {
            $isValid = self::isOptional($pattern);
        } elseif (\is_array($value)) {
            $isValid = true;
            if (!$allowUnknownParameters) {
                foreach ($value as $valueKey => $valueVal) {
                    if (!\is_int($valueKey) && !isset($pattern[$valueKey])) {
                        $isValid = false;
                        break;
                    }
                }
            }

            if ($isValid) {
                foreach ($pattern as $patternKey => $patternItem) {
                    $valueVal = $value[$patternKey] ?? null;
                    if ($patternItem instanceof ConstraintInterface) {
                        if (!$patternItem->isValidValue($valueVal)) {
                            $isValid = false;
                            break;
                        }
                    } elseif (\is_array($patternItem)) {
                        if (self::isConstraintArray($patternItem)) {
                            foreach ($patternItem as $constraint) {
                                if ($constraint instanceof ConstraintInterface) {
                                    if (!($constraint->isValidValue($valueVal))) {
                                        $isValid = false;
                                        break;
                                    }
                                } else {
                                    $isValid = false;
                                }
                            }
                        } elseif (
                            !self::isValid(
                                $patternItem,
                                $valueVal,
                                $allowUnknownParameters,
                                null,
                                $errors
                            )
                        ) {
                            $isValid = false;
                            break;
                        }
                    } else {
                        $isValid = false;
                        break;
                    }
                }
            }
        }

        if ($isValid) {
            return true;
        }

        if (null !== $errors) {
            if (null === $value) {
                if (!self::isOptional($pattern)) {
                    $errors[] = self::toErrorMessage($value, $valueName, 'Missing mandatory values');
                }
            } elseif (\is_array($value)) {
                if (!$allowUnknownParameters) {
                    foreach ($value as $valueKey => $valueVal) {
                        if (!\is_int($valueKey) && !isset($pattern[$valueKey])) {
                            $format = 'Found unknown field [%s]';
                            $errors[] = self::toErrorMessage(
                                $valueVal,
                                $valueName,
                                $format,
                                Format::toString($valueKey)
                            );
                        }
                    }
                }

                foreach ($pattern as $patternKey => $patternItem) {
                    $valueVal = $value[$patternKey] ?? null;
                    if ($patternItem instanceof ConstraintInterface) {
                        $nam = ((null === $valueName) || ('' === $valueName) ? '' : $valueName . '.') . $patternKey;
                        $patternItem->isValidValue($valueVal, $nam, $errors);
                    } elseif (\is_array($patternItem)) {
                        if (self::isConstraintArray($patternItem)) {
                            foreach ($patternItem as $key => $constraint) {
                                $nam = ((null === $valueName) || ('' === $valueName) ? '' : $valueName . '.')
                                    . $patternKey . '.' . $key;
                                if ($constraint instanceof ConstraintInterface) {
                                    $constraint->isValidValue($valueVal, $nam, $errors);
                                } else {
                                    $errors[] = self::toErrorMessage($value, $nam, 'Constraint expected');
                                }
                            }
                        } else {
                            self::isValid(
                                $patternItem,
                                $valueVal,
                                $allowUnknownParameters,
                                ((null === $valueName) || ('' === $valueName) ? '' : $valueName . '.') . $patternKey,
                                $errors
                            );
                        }
                    } else {
                        $nam = ((null === $valueName) || ('' === $valueName) ? '' : $valueName . '.') . $patternKey;
                        $errors[] = self::toErrorMessage($value, $nam, 'Constraint or array expected');
                    }
                }
            }
        }
        return false;
    }

    /**
     * @param array $pattern
     * @return bool
     */
    private static function isOptional(array $pattern): bool
    {
        if ([] === $pattern) {
            return true;
        }
        foreach ($pattern as $patternItem) {
            if ($patternItem instanceof ConstraintInterface) {
                $className = \get_class($patternItem);
                if (!str_contains($className, 'OrNull')) {
                    return false;
                }
            } elseif (\is_array($patternItem)) {
                if (self::isConstraintArray($patternItem)) {
                    foreach ($patternItem as $constraint) {
                        $className = \get_class($constraint);
                        if (!str_contains($className, 'OrNull')) {
                            return false;
                        }
                    }
                } elseif (!self::isOptional($patternItem)) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $array
     * @return bool
     */
    private static function isConstraintArray(array $array): bool
    {
        /** @noinspection LoopWhichDoesNotLoopInspection */
        foreach ($array as $key => $value) {
            if ((0 !== $key) || (!($value instanceof ConstraintInterface))) {
                return false; // intended incomplete check
            }
            break;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->pattern, $value, $this->allowUnknownParameters, $valueName, $message);
    }

    /**
     * @param array       $pattern
     * @param mixed       $value
     * @param string|null $valueName
     * @param bool        $allowUnknownParameters
     * @param string|null $message
     */
    public static function assert(
        array $pattern,
        mixed $value,
        bool $allowUnknownParameters = false,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($pattern, $value, $allowUnknownParameters, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        $items = [0 => $this->pattern, 1 => $this->allowUnknownParameters];
        return \serialize($items);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $items = \unserialize($data, ['allowed_class' => true]);
        $this->pattern = $items[0];
        $this->allowUnknownParameters = $items[1];
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [$this->pattern, $this->allowUnknownParameters];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->pattern = $data[0];
        $this->allowUnknownParameters = $data[1];
    }
}
