<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsGreater.php
 * Class name...: IsGreater.php
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
 * Class Maximum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsGreater extends AbstractConstraint
{
    /**
     * @var int|float
     */
    private $minimum;

    /**
     * Maximum constructor.
     * @param int|float $minimum
     * @throws ConstraintViolationException
     */
    public function __construct($minimum)
    {
        IsNumeric::assert($minimum);

        $this->minimum = $minimum;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->minimum, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->minimum, $value, $valueName, $errors);
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param             $minimum
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid($minimum, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsNumeric::assert($minimum);

        if (is_numeric($value) && ($value > $minimum)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Numeric value greater than [%' . (is_int($minimum) ? 'd' : 'f') . '] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $minimum);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->minimum, $value, $valueName, $message);
    }

    /**
     * @param int|float   $minimum
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        $minimum,
        $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($minimum, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->minimum);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->minimum = unserialize($data);
    }
}