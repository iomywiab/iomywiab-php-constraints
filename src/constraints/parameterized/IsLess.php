<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsLess.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsLess.php
 * Class name...: IsLess.php
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
 * File name....: IsLess.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsLess.php
 * Class name...: IsLess.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNumeric;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Class maximum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsLess extends AbstractConstraint
{
    /**
     * @var int|float
     */
    private $maximum;

    /**
     * Maximum constructor.
     * @param int|float $maximum
     * @throws ConstraintViolationException
     */
    public function __construct($maximum)
    {
        IsNumeric::assert($maximum);

        $this->maximum = $maximum;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->maximum, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->maximum, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param int|float   $maximum
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid($maximum, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsNumeric::assert($maximum);

        if (is_numeric($value) && ($value < $maximum)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Numeric value smaller than maximum [%' . (is_int($maximum) ? 'd' : 'f') . '] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $maximum);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->maximum, $value, $valueName, $message);
    }

    /**
     * @param int|float   $maximum
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        $maximum,
        $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($maximum, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->maximum);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->maximum = unserialize($data);
    }
}