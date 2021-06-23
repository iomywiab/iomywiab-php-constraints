<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsType.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsType.php
 * Class name...: IsType.php
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
 * File name....: IsType.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsType.php
 * Class name...: IsType.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:36
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsValidType;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Class Type
 * @package iomywiab\iomywiab_php_constraints
 */
class IsType extends AbstractConstraint
{
    public const BOOL = IsValidType::BOOL;
    public const INT = IsValidType::INT;
    public const FLOAT = IsValidType::FLOAT;
    public const STRING = IsValidType::STRING;
    public const ARRAY = IsValidType::ARRAY;
    public const OBJECT = IsValidType::OBJECT;

    public const ALL_TYPES = IsValidType::ALL_TYPES;


    /**
     * @var string
     */
    private $type;

    /**
     * Type constructor.
     * @param string $type
     * @throws ConstraintViolationException
     */
    public function __construct(string $type)
    {
        IsValidType::assert($type);
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->type, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->type, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param string      $type
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(string $type, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsValidType::assert($type);

        if ($type == gettype($value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Type [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $type);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->type, $value, $valueName, $message);
    }

    /**
     * @param string      $type
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(string $type, $value, ?string $valueName = null, ?string $message = null): void
    {
        $errors = [];
        if (!static::isValid($type, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->type);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->type = unserialize($data);
    }
}