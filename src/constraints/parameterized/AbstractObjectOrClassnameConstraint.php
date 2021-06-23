<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractObjectOrClassnameConstraint.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/AbstractObjectOrClassnameConstraint.php
 * Class name...: AbstractObjectOrClassnameConstraint.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:29
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractObjectOrClassnameConstraint.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/AbstractObjectOrClassnameConstraint.php
 * Class name...: AbstractObjectOrClassnameConstraint.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:42
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsTrue;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class AbstractObjectOrClassnameConstraint
 * @package iomywiab\iomywiab_php_constraints
 */
abstract class AbstractObjectOrClassnameConstraint extends AbstractConstraint
{
    /**
     * @param mixed|string $value
     * @param array|null   $errors
     * @return bool
     */
    private $objectOrClass;

    /**
     * IsArrayMaxCount constructor.
     * @param $objectOrClass
     * @throws ConstraintViolationException
     */
    public function __construct($objectOrClass)
    {
        IsTrue::assert(is_object($objectOrClass) || is_string($objectOrClass));

        $this->objectOrClass = $objectOrClass;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->objectOrClass, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->objectOrClass, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param             $objectOrClass
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    // @codeCoverageIgnoreStart
    public static function isValid($objectOrClass, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsTrue::assert(is_object($objectOrClass) || is_string($objectOrClass));

        if (null !== $errors) {
            $errors[] = 'Constraint [' . static::class . '] is incomplete: Method [isValid] is not overloaded. Value '
                . Format::toDescription($value) . ' cannot be verified against '
                . Format::toDescription($objectOrClass) . '';
        }
        return false;
    }
    // @codeCoverageIgnoreEnd

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->objectOrClass, $value, $valueName, $message);
    }

    /**
     * @param             $objectOrClass
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        $objectOrClass,
        $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($objectOrClass, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->objectOrClass);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->objectOrClass = unserialize($data);
    }
}