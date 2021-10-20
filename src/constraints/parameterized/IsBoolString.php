<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsBoolString.php
 * Class name...: IsBoolString.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsArraySameTypeItems;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class StandardBoolString
 * @package iomywiab\iomywiab_php_constraints
 */
class IsBoolString extends AbstractConstraint
{
    public const DEFAULT_BOOLEAN_STRINGS = [
        Format::TRUE_STRING => true,
        Format::FALSE_STRING => false,

        '1' => true,
        '0' => false,

        'on' => true,
        'off' => false,

        'yes' => true,
        'no' => false,

        'y' => true,
        'n' => false,

        'enabled' => true,
        'disabled' => false,

        'activated' => true,
        'deactivated' => false,

        'active' => true,
        'inactive' => false
    ];

    /**
     * @var bool[]  name(string) => bool
     */
    private $lowercaseStrings;

    /**
     * Instance constructor.
     * @param string[]|null $lowercaseStrings
     * @throws ConstraintViolationException
     */
    public function __construct(?array $lowercaseStrings = self::DEFAULT_BOOLEAN_STRINGS)
    {
        if (null === $lowercaseStrings) {
            $this->lowercaseStrings = self::DEFAULT_BOOLEAN_STRINGS;
        } else {
            IsArraySameTypeItems::assert($lowercaseStrings);
            $this->lowercaseStrings = $lowercaseStrings;
        }
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($value, $valueName, $this->lowercaseStrings, $errors);
    }

    /**
     * @param array       $lowercaseStrings
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid(
        $value,
        ?string $valueName = null,
        array $lowercaseStrings = self::DEFAULT_BOOLEAN_STRINGS,
        array &$errors = null
    ): bool {
//        if (is_string($value) && array_key_exists($value, $lowercaseStrings)) {
        if (is_string($value) && isset($lowercaseStrings[$value])) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Boolean string expected. Valid values=[%s]';
            $errors[] = self::toErrorMessage(
                $value,
                $valueName,
                $format,
                Format::toValueList(array_keys($lowercaseStrings))
            );
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($value, $valueName, $this->lowercaseStrings, $message);
    }

    /**
     * @param array       $lowercaseStrings
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        $value,
        ?string $valueName = null,
        array $lowercaseStrings = self::DEFAULT_BOOLEAN_STRINGS,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($value, $valueName, $lowercaseStrings, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->lowercaseStrings);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->lowercaseStrings = unserialize($data);
    }


}