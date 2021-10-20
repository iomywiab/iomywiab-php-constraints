<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsInRange.php
 * Class name...: IsInRange.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNumeric;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Class StandardUnsigned
 * @package iomywiab\iomywiab_php_constraints
 */
class IsInRange extends AbstractConstraint
{
    /**
     * @var int|float
     */
    protected $maximum;

    /**
     * @var int|float
     */
    protected $minimum;

    /**
     * Range constructor.
     * @param int|float $minimum
     * @param int|float $maximum
     * @throws ConstraintViolationException
     */
    public function __construct($minimum, $maximum)
    {
        IsNumeric::assert($minimum);
        IsNumeric::assert($maximum);
        IsGreaterOrEqual::assert($minimum, $maximum);
        IsLessOrEqual::assert($maximum, $minimum);

        $this->minimum = $minimum;
        $this->maximum = $maximum;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->minimum, $this->maximum, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->minimum, $this->maximum, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param int|float   $minimum
     * @param int|float   $maximum
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid($minimum, $maximum, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsNumeric::assert($minimum);
        IsNumeric::assert($maximum);
        IsGreaterOrEqual::assert($minimum, $maximum);
        IsLessOrEqual::assert($maximum, $minimum);

        if (is_numeric($value) && ($minimum <= $value) && ($value <= $maximum)) {
            return true;
        }

        if (null !== $errors) {
            $minType = is_int($minimum) ? 'd' : 'f';
            $maxType = is_int($maximum) ? 'd' : 'f';
            $format = 'Numeric value in range [%' . $minType . ',%' . $maxType . '] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $minimum, $maximum);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->minimum, $this->maximum, $value, $valueName, $message);
    }

    /**
     * @param int|float   $minimum
     * @param int|float   $maximum
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        $minimum,
        $maximum,
        $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($minimum, $maximum, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize([0 => $this->minimum, 1 => $this->maximum]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $both = unserialize($data);
        $this->minimum = $both[0];
        $this->maximum = $both[1];
    }
}