<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsEqual.php
 * Class name...: IsEqual.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class maximum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsEqual extends AbstractConstraint
{
    public const DEFAULT_STRICT = true;

    /**
     * @var mixed
     */
    private $expected;

    /**
     * @var bool
     */
    private $strict;

    /**
     * Maximum constructor.
     * @param mixed $expected
     * @param bool  $strict
     */
    public function __construct($expected, bool $strict = self::DEFAULT_STRICT)
    {
        $this->expected = $expected;
        $this->strict = $strict;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->expected, $value, $valueName, $this->strict, $errors);
    }

    /**
     * @param mixed       $expected
     * @param mixed       $actual
     * @param string|null $valueName
     * @param bool        $strict
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid(
        $expected,
        $actual,
        ?string $valueName = null,
        bool $strict = self::DEFAULT_STRICT,
        array &$errors = null
    ): bool {
        if ($strict && ($expected === $actual)) {
            return true;
        } elseif (!$strict && ($expected == $actual)) {
            return true;
        }

        if (null !== $errors) {
            $expected = Format::toDescription($expected);
            $format = 'Expected value [%s] is not equal to actual';
            $errors[] = self::toErrorMessage($actual, $valueName, $format, $expected);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->expected, $value, $valueName, $this->strict, $message);
    }

    /**
     * @param mixed       $expected
     * @param mixed       $actual
     * @param string|null $valueName
     * @param bool        $strict
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        $expected,
        $actual,
        ?string $valueName = null,
        bool $strict = self::DEFAULT_STRICT,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($expected, $actual, $valueName, $strict, $errors)) {
            throw new ConstraintViolationException(static::class, $actual, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize([0 => $this->expected, 1 => $this->strict]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $array = unserialize($data);
        $this->expected = $array[0];
        $this->strict = $array[1];
    }
}