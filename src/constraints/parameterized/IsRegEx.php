<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsRegEx.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsRegEx.php
 * Class name...: IsRegEx.php
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
 * File name....: IsRegEx.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/parameterized/IsRegEx.php
 * Class name...: IsRegEx.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:36
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringNotEmpty;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Class RegEx
 * @package iomywiab\iomywiab_php_constraints
 */
class IsRegEx extends AbstractConstraint
{
    /**
     * @var string
     */
    private $regEx;

    /**
     * Instance constructor.
     * @param string $regEx
     * @throws ConstraintViolationException
     */
    public function __construct(string $regEx)
    {
        IsStringNotEmpty::assert($regEx);

        $this->regEx = $regEx;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->regEx, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->regEx, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param string      $regEx
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(string $regEx, $value, ?string $valueName = null, array &$errors = null): bool
    {
        IsStringNotEmpty::assert($regEx);

        if (is_string($value) && (1 == preg_match($regEx, $value))) {
            return true;
        }

        if (null !== $errors) {
            $format = 'String matching [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $regEx);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->regEx, $value, $valueName, $message);
    }

    /**
     * @param string      $regEx
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(string $regEx, $value, ?string $valueName = null, ?string $message = null): void
    {
        $errors = [];
        if (!static::isValid($regEx, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize($this->regEx);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->regEx = unserialize($data);
    }

}