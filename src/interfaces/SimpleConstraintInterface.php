<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: SimpleConstraintInterface.php
 * Class name...: SimpleConstraintInterface.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\interfaces;

use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Interface ConstraintInterface
 * @package iomywiab\iomywiab_php_constraints\interfaces
 */
interface SimpleConstraintInterface extends ConstraintInterface
{

    /**
     * @param mixed       $value
     * @param string|null $valueName
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid(/*no_parameters, */ $value, ?string $valueName = null, array &$errors = null): bool;

    /**
     * @param mixed       $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(/*no_parameters, */ $value, ?string $valueName = null, ?string $message = null): void;

}