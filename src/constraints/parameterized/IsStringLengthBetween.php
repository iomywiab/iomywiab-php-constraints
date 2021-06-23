<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringLengthBetween.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsStringLengthBetween.php
 * Class name...: IsStringLengthBetween.php
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
 * File name....: IsStringLengthBetween.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsStringLengthBetween.php
 * Class name...: IsStringLengthBetween.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsInteger;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Class StandardUnsigned
 * @package iomywiab\iomywiab_php_constraints
 */
class IsStringLengthBetween extends AbstractConstraint
{
    /**
     * @var int
     */
    protected $maximum;

    /**
     * @var int
     */
    protected $minimum;

    /**
     * Range constructor.
     * @param int $minimum
     * @param int $maximum
     * @throws ConstraintViolationException
     */
    public function __construct(int $minimum, int $maximum)
    {
        IsInteger::assert($minimum);
        IsInteger::assert($maximum);
        IsGreaterOrEqual::assert(0, $minimum);
        IsGreaterOrEqual::assert($minimum, $maximum);

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
     * @param int         $minimum
     * @param int         $maximum
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        int $minimum,
        int $maximum,
        $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        IsInteger::assert($minimum);
        IsInteger::assert($maximum);
        IsGreaterOrEqual::assert(0, $minimum);
        IsGreaterOrEqual::assert($minimum, $maximum);

        if (is_string($value)) {
            $len = strlen($value);
            if (($minimum <= $len) && ($len <= $maximum)) {
                return true;
            }
        }

        if (null !== $errors) {
            $format = 'String of length [%d,%d] expected';
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