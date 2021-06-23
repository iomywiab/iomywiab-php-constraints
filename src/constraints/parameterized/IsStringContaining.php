<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringContaining.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsStringContaining.php
 * Class name...: IsStringContaining.php
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
 * File name....: IsStringContaining.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsStringContaining.php
 * Class name...: IsStringContaining.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
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
class IsStringContaining extends AbstractConstraint
{

    /**
     * @var string
     */
    private $subString;

    /**
     * Instance constructor.
     * @param string $subString
     * @throws ConstraintViolationException
     */
    public function __construct(string $subString)
    {
        IsStringNotEmpty::assert($subString);
        $this->subString = $subString;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->subString, $value, $valueName, $errors);
    }

    /**
     * @param string      $subString
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid(string $subString, $value, ?string $valueName = null, array &$errors = null): bool
    {
        if (is_string($value) && (false !== strpos($value, $subString))) {
            return true;
        }

        if (null !== $errors) {
            $format = 'String containing [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $subString);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->subString, $value, $valueName, $message);
    }

    /**
     * @param string      $subString
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        string $subString,
        $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($subString, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->subString);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->subString = unserialize($data);
    }

}