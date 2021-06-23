<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractMinimumIntConstraint.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/AbstractMinimumIntConstraint.php
 * Class name...: AbstractMinimumIntConstraint.php
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
 * File name....: AbstractMinimumIntConstraint.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/AbstractMinimumIntConstraint.php
 * Class name...: AbstractMinimumIntConstraint.php
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
 * Class AbstractMinimumIntConstraint
 * @package iomywiab\iomywiab_php_constraints
 */
abstract class AbstractMinimumIntConstraint extends AbstractConstraint
{
    /**
     * @var int
     */
    private $minimum;

    /**
     * IsArrayMinCount constructor.
     * @param int $minimum
     * @throws ConstraintViolationException
     */
    public function __construct(int $minimum)
    {
        IsGreaterOrEqual::assert(0, $minimum);

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
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    // @codeCoverageIgnoreStart
    public static function isValid(int $minimum, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsGreaterOrEqual::assert(0, $minimum);

        if (null !== $errors) {
            $errors[] = 'Constraint [' . static::class . '] is incomplete: Method [isValid] is not overloaded. Value '
                . Format::toDescription($value) . ' cannot be verified against ' . Format::toDescription($minimum);
        }
        return false;
    }
    // @codeCoverageIgnoreEnd

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->minimum, $value, $valueName, $message);
    }

    /**
     * @param int         $minimum
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        int $minimum,
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