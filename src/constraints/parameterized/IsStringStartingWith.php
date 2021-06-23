<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsStringStartingWith.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsStringStartingWith.php
 * Class name...: IsStringStartingWith.php
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
 * File name....: IsStringStartingWith.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsStringStartingWith.php
 * Class name...: IsStringStartingWith.php
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
class IsStringStartingWith extends AbstractConstraint
{

    /**
     * @var string
     */
    private $prefix;

    /**
     * Instance constructor.
     * @param string $prefix
     * @throws ConstraintViolationException
     */
    public function __construct(string $prefix)
    {
        IsStringNotEmpty::assert($prefix);
        $this->prefix = $prefix;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->prefix, $value, $valueName, $errors);
    }

    /**
     * @param string      $prefix
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid(string $prefix, $value, ?string $valueName = null, array &$errors = null): bool
    {
        if (is_string($value) && (0 === strpos($value, $prefix))) {
            return true;
        }

        if (null !== $errors) {
            $format = 'String starting with [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $prefix);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->prefix, $value, $valueName, $message);
    }

    /**
     * @param string      $prefix
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        string $prefix,
        $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($prefix, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->prefix);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->prefix = unserialize($data);
    }

}