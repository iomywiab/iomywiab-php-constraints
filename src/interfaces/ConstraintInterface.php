<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ConstraintInterface.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\interfaces;

use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * @psalm-immutable
 */
interface ConstraintInterface extends \Serializable
{
    /**
     * Always calls static::isValid and enriches the parameter list with values stored in the constraint object (if any)
     *
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool;

    /**
     * Always calls static::assert and enriches the parameter list with values stored in the constraint object (if any).
     *
     * @param mixed       $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void;

//    /**
//     * This is where all the checks happen - the heart of the constraint.
//     * The number of parameters might differ depending on the check.
//     * Parameters are ALWAYS checked here. (Duplicated checks from constructor -> performance lack, but needed)
//     * Always checks is the given value is valid. Basic structure:
//     *
//     * $isOk = true; // assume value is valid
//     * foreach(checks) { // run all checks (those checks might run sub checks themselves)
//     *    if (!check->isValid($value)) { // if check fails
//     *       $isOk = false;
//     *       break;                      // then stop checking immediately
//     *    }
//     * }
//     * if (isOk) return true; // stop processing here if all checks succeeded
//     * if (null !== $errors) { // if the caller provided a buffer for errors then fill it
//     *    foreach(checks) { // run all checks (those checks might run sub checks themselves and fill $errors)
//     *       check->isValid($value,$errors)) {
//     *    }
//     * }
//     * return false;
//     *
//     * @param mixed       $value will be validated. function returns true if value passes all checks, false otherwise
//     * @param string|null $valueName might get validated and throws exceptions on failure.
//     * @param array<int,string>|null  $errors might get validated and throws exceptions on failure.
//     * @return bool result of checking $value.
//     * @throws ConstraintViolationException this exception is thrown if parameters other than $value are invalid.
//     */
//    public static function isValid(
//        /* additional MANDATORY parameters here (these parameters should get validated before executing this check) */
//        mixed $value,
//        /* additional OPTIONAL parameters here (these parameters should get validated before executing this check), */
//        ?string $valueName = null,
//        array &$errors = null): bool;
//
//    /**
//     * Always calls static:isValid and throws an exception is isValid return false
//     * The number of parameters might differ depending on the check.
//     * Parameters are NOT checked in this method.
//     *
//     * @param mixed       $value
//     * @param string|null $valueName
//     * @param array<int,string>|null  $errors
//     * @throws ConstraintViolationException thrown if value or other parameters are invalid.
//     */
//    public static function assert(
//        /* additional MANDATORY parameters here (these parameters should NOT get validated here), */
//        mixed $value,
//        /* additional OPTIONAL parameters here (these parameters should NOT get validated here), */
//        ?string $valueName = null,
//        array &$errors = null): void;
}
