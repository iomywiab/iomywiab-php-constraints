<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsParameters.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/combined/IsParameters.php
 * Class name...: IsParameters.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:58:05
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsParameters.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/combined/IsParameters.php
 * Class name...: IsParameters.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\combined;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;
use iomywiab\iomywiab_php_constraints\interfaces\ConstraintInterface;

/**
 * Class Parameters
 * @package iomywiab\iomywiab_php_constraints
 */
class IsParameters extends AbstractConstraint
{
    public const ALLOW_OTHERS = true;
    public const DEFINED_ONLY = false;

    /**
     * @var bool
     */
    private $allowUnknownParameters;

    /**
     * @var array name(string => ConstraintInterface|ConstraintInterface[]|mixed[]
     */
    private $pattern;

    /**
     * Parameters constructor.
     * @param bool  $allowUnknownParameters
     * @param array $pattern
     */
    public function __construct(array $pattern, bool $allowUnknownParameters = false)
    {
        $this->pattern = $pattern;
        $this->allowUnknownParameters = $allowUnknownParameters;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->pattern, $value, $valueName, $this->allowUnknownParameters, $errors);
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
     * @param array       $pattern
     * @param mixed       $value
     * @param string|null $valueName
     * @param bool        $allowUnknownParameters
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        array $pattern,
        $value,
        ?string $valueName = null,
        bool $allowUnknownParameters = false,
        array &$errors = null
    ): bool {
        if (empty($value) && empty($pattern)) {
            return true;
        }

        $isValid = false;
        if (null === $value) {
            $isValid = self::isOptional($pattern);
        } elseif (is_array($value)) {
            $isValid = true;
            if (!$allowUnknownParameters) {
                foreach ($value as $valueKey => $valueVal) {
                    if (!is_int($valueKey) && !array_key_exists($valueKey, $pattern)) {
                        $isValid = false;
                        break;
                    }
                }
            }

            if ($isValid) {
                foreach ($pattern as $patternKey => $patternItem) {
                    $valueVal = array_key_exists($patternKey, $value) ? $value[$patternKey] : null;
                    if ($patternItem instanceof ConstraintInterface) {
                        if (!$patternItem->isValidValue($valueVal)) {
                            $isValid = false;
                            break;
                        }
                    } elseif (is_array($patternItem)) {
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
                        } elseif (!self::isValid(
                            $patternItem,
                            $valueVal,
                            null,
                            $allowUnknownParameters,
                            $errors
                        )) {
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
            } elseif (is_array($value)) {
                if (!$allowUnknownParameters) {
                    foreach ($value as $valueKey => $valueVal) {
                        if (!is_int($valueKey) && !array_key_exists($valueKey, $pattern)) {
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
                    $valueVal = array_key_exists($patternKey, $value) ? $value[$patternKey] : null;
                    if ($patternItem instanceof ConstraintInterface) {
                        $nam = (empty($valueName) ? '' : $valueName . '.') . $patternKey;
                        $patternItem->isValidValue($valueVal, $nam, $errors);
                    } elseif (is_array($patternItem)) {
                        if (self::isConstraintArray($patternItem)) {
                            foreach ($patternItem as $key => $constraint) {
                                $nam = (empty($valueName) ? '' : $valueName . '.') . $patternKey . '.' . $key;
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
                                (empty($valueName) ? '' : $valueName . '.') . $patternKey,
                                $allowUnknownParameters,
                                $errors
                            );
                        }
                    } else {
                        $nam = (empty($valueName) ? '' : $valueName . '.') . $patternKey;
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
        if (empty($pattern)) {
            return true;
        }
        foreach ($pattern as $patternItem) {
            if ($patternItem instanceof ConstraintInterface) {
                $className = get_class($patternItem);
                if (false === strpos($className, 'OrNull')) {
                    return false;
                }
            } elseif (is_array($patternItem)) {
                if (self::isConstraintArray($patternItem)) {
                    foreach ($patternItem as $constraint) {
                        $className = get_class($constraint);
                        if (false === strpos($className, 'OrNull')) {
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
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->pattern, $value, $valueName, $this->allowUnknownParameters, $message);
    }

    /**
     * @param array       $pattern
     * @param             $value
     * @param string|null $valueName
     * @param bool        $allowUnknownParameters
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        array $pattern,
        $value,
        ?string $valueName = null,
        bool $allowUnknownParameters = false,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($pattern, $value, $valueName, $allowUnknownParameters, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        $items = [0 => $this->pattern, 1 => $this->allowUnknownParameters];
        return serialize($items);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $items = unserialize($data);
        $this->pattern = $items[0];
        $this->allowUnknownParameters = $items[1];
    }

}