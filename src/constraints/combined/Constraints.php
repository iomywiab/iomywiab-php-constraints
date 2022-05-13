<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: Constraints.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\combined;

use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsGreaterOrEqual;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsInArray;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsLessOrEqual;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsRegEx;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMaxLength;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMinLength;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotEmpty;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * @psalm-immutable
 */
class Constraints extends AbstractConstraintContainer
{
    public const IDX_NOT_EMPTY = -1;
    public const IDX_NOT_NULL = -2;
    public const IDX_REGEX = -3;
    public const IDX_TYPE = -4;
    public const IDX_MAX_LEN = -5;
    public const IDX_MIN_LEN = -6;
    public const IDX_MAX = -7;
    public const IDX_MIN = -8;
    public const IDX_IN_ARRAY = -9;

    /**
     * @param float|int $maximum
     * @return Constraints
     * @throws ConstraintViolationException
     */
    public function setMaximum(int|float $maximum): Constraints
    {
        $this->constraints[self::IDX_MAX] = new IsLessOrEqual($maximum);
        return $this;
    }

    /**
     * @param int $maxLength
     * @return Constraints
     * @throws ConstraintViolationException
     */
    public function setMaxLength(int $maxLength): Constraints
    {
        $this->constraints[self::IDX_MAX_LEN] = new IsStringMaxLength($maxLength);
        return $this;
    }

    /**
     * @param float|int $minimum
     * @return Constraints
     * @throws ConstraintViolationException
     */
    public function setMinimum(int|float $minimum): Constraints
    {
        $this->constraints[self::IDX_MIN] = new IsGreaterOrEqual($minimum);
        return $this;
    }

    /**
     * @param int $minLength
     * @return Constraints
     * @throws ConstraintViolationException
     */
    public function setMinLength(int $minLength): Constraints
    {
        $this->constraints[self::IDX_MIN_LEN] = new IsStringMinLength($minLength);
        return $this;
    }

    /**
     * @return Constraints
     */
    public function setNotEmpty(): Constraints
    {
        $this->constraints[self::IDX_NOT_EMPTY] = new IsNotEmpty();
        return $this;
    }

    /**
     * @return Constraints
     */
    public function setNotNull(): Constraints
    {
        $this->constraints[self::IDX_NOT_NULL] = new IsNotNull();
        return $this;
    }

    /**
     * @param string $regEx
     * @return Constraints
     * @throws ConstraintViolationException
     */
    public function setRegEx(string $regEx): Constraints
    {
        $this->constraints[self::IDX_REGEX] = new IsRegEx($regEx);
        return $this;
    }

    /**
     * @param string $type
     * @return Constraints
     * @throws ConstraintViolationException
     */
    public function setType(string $type): Constraints
    {
        $this->constraints[self::IDX_TYPE] = new IsType($type);
        return $this;
    }

    /**
     * @param array $array
     * @return Constraints
     * @throws ConstraintViolationException
     */
    public function setInArray(array $array): Constraints
    {
        $this->constraints[self::IDX_IN_ARRAY] = new IsInArray($array);
        return $this;
    }
}
