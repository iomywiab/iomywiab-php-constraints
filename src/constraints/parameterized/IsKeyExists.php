<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsKeyExists.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsKeyExists.php
 * Class name...: IsKeyExists.php
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
 * File name....: IsKeyExists.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsKeyExists.php
 * Class name...: IsKeyExists.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class Enum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsKeyExists extends AbstractConstraint
{

    /**
     * @var array
     */
    private $array;

    /**
     * Instance constructor.
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->array, $value, $valueName, $errors);
    }

    /**
     * @param array       $array
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid(array $array, $value, ?string $valueName = null, array &$errors = null): bool
    {
        if ((is_int($value) || is_string($value)) && (isset($array[$value]) || array_key_exists($value, $array))) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Key for array %s expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toString($array));
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->array, $value, $valueName, $message);
    }

    /**
     * @param array       $array
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(array $array, $value, ?string $valueName = null, ?string $message = null): void
    {
        $errors = [];
        if (!static::isValid($array, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->array);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->array = unserialize($data);
    }
}