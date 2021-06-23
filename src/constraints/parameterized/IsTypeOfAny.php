<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsTypeOfAny.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsTypeOfAny.php
 * Class name...: IsTypeOfAny.php
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
 * File name....: IsTypeOfAny.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsTypeOfAny.php
 * Class name...: IsTypeOfAny.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsValidTypeArray;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class Type
 * @package iomywiab\iomywiab_php_constraints
 */
class IsTypeOfAny extends AbstractConstraint
{
    /**
     * @var string[]
     */
    private $types;

    /**
     * Type constructor.
     * @param string[] $types
     * @throws ConstraintViolationException
     */
    public function __construct(array $types)
    {
        IsValidTypeArray::assert($types);

        $this->types = $types;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->types, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->types, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param string[]    $types
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(array $types, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsValidTypeArray::assert($types);

        $type = gettype($value);
        if (in_array($type, $types)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Type [%s] expected';
            $list = Format::toValueList($types);
            $errors[] = self::toErrorMessage($value, $valueName, $format, $list);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->types, $value, $valueName, $message);
    }

    /**
     * @param string[]    $types
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(array $types, $value, ?string $valueName = null, ?string $message = null): void
    {
        $errors = [];
        if (!static::isValid($types, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->types);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->types = unserialize($data);
    }
}