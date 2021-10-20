<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringEndingWith.php
 * Class name...: IsStringEndingWith.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:32
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringNotEmpty;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Class Numeric
 * @package iomywiab\iomywiab_php_constraints
 */
class IsStringEndingWith extends AbstractConstraint
{

    /**
     * @var string
     */
    private $endString;

    /**
     * Instance constructor.
     * @param string $endString
     * @throws ConstraintViolationException
     */
    public function __construct(string $endString)
    {
        IsStringNotEmpty::assert($endString);
        $this->endString = $endString;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->endString, $value, $valueName, $errors);
    }

    /**
     * @param string      $endString
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid(string $endString, $value, ?string $valueName = null, array &$errors = null): bool
    {
        if (is_string($value)) {
            $lenEnd = strlen($endString);
            $lenValue = strlen($value);
            $expectedPos = $lenValue - $lenEnd;
            if ((0 <= $expectedPos) && ($expectedPos <= $lenValue)
                && ($expectedPos === strpos($value, $endString, $expectedPos))) {
                return true;
            }
        }

        if (null !== $errors) {
            $format = 'String ending with [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $endString);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->endString, $value, $valueName, $message);
    }

    /**
     * @param string      $endString
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        string $endString,
        $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($endString, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->endString);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->endString = unserialize($data);
    }

}