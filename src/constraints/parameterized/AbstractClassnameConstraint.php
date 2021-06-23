<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractClassnameConstraint.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/AbstractClassnameConstraint.php
 * Class name...: AbstractClassnameConstraint.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:30
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractClassnameConstraint.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/AbstractClassnameConstraint.php
 * Class name...: AbstractClassnameConstraint.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringNotEmpty;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Class AbstractClassnameConstraint
 * @package iomywiab\iomywiab_php_constraints
 */
abstract class AbstractClassnameConstraint extends AbstractConstraint
{
    /**
     * @var string
     */
    private $className;

    /**
     * Instance constructor.
     * @param string $className
     * @throws ConstraintViolationException
     */
    public function __construct(string $className)
    {
        IsStringNotEmpty::assert($className);

        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->className, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->className, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

//    /**
//     *
//     * @param string      $className
//     * @param             $value
//     * @param string|null $valueName
//     * @param array|null  $errors
//     * @return bool
//     * @throws ConstraintViolationException
//     */
//    public static function isValid(string $className, $value, ?string $valueName = null, array &$errors = null): bool
//    {
//        IsStringNotEmpty::assert($className);
//
//        if (null !== $errors) {
//            $errors[] = 'Constraint [' . static::class . '] is incomplete: Method [isValid] is not overloaded. Value '
//                . Format::toDescription($value) . ' cannot be verified against ' . Format::toDescription($className);
//        }
//        return false;
//    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->className, $value, $valueName, $message);
    }

    /**
     * @param             $value
     * @param string      $className
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(string $className, $value, ?string $valueName = null, ?string $message = null): void
    {
        IsStringNotEmpty::assert($className);

        $errors = [];
        if (!static::isValid($className, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->className);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->className = unserialize($data);
    }
}