<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOrInstanceOfAny.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsTypeOrInstanceOfAny.php
 * Class name...: IsTypeOrInstanceOfAny.php
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
 * File name....: IsTypeOrInstanceOfAny.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsTypeOrInstanceOfAny.php
 * Class name...: IsTypeOrInstanceOfAny.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:36
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotEmpty;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsValidTypeArray;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class IsTypeOrInstanceOfAny
 * @package iomywiab\iomywiab_php_constraints\parameterized
 */
class IsTypeOrInstanceOfAny extends AbstractConstraint
{
    /**
     * @var string[]
     */
    private $types;

    /**
     * @var array
     */
    private $classesAndInterfaces;

    /**
     * IsTypeOrInstanceOfAny constructor.
     * @param string[] $types
     * @param array    $classesAndInterfaces
     * @throws ConstraintViolationException
     */
    public function __construct(array $types, array $classesAndInterfaces)
    {
        IsValidTypeArray::assert($types);
        IsNotEmpty::assert($classesAndInterfaces);
        $this->types = $types;
        $this->classesAndInterfaces = $classesAndInterfaces;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
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
     * @param array       $types
     * @param array       $classesAndInterfaces
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        array $types,
        array $classesAndInterfaces,
        $value,
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
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->types, $this->classesAndInterfaces, $value, $valueName, $message);
    }

    /**
     * @param array       $types
     * @param array       $classesAndInterfaces
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        array $types,
        array $classesAndInterfaces,
        $value,
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
        return serialize([$this->types, $this->classesAndInterfaces]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $tmp = unserialize($data);
        $this->types = $tmp[0];
        $this->classesAndInterfaces = $tmp[1];
    }
}