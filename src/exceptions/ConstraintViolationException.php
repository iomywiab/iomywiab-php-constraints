<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ConstraintViolationException.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\exceptions;

use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * Class ConstraintViolationException
 *
 * Formerly based on InvalidArgumentException, now derived from LogicException
 * InvalidArgumentException extends LogicException and signals programming errors
 * UnexpectedValueException extends RuntimeException and signals values from user or config.
 * @psalm-immutable
 */
class ConstraintViolationException extends \LogicException
{
    /**
     * ConstraintViolationException constructor.
     * @param string|null     $constraintClassName
     * @param mixed           $value
     * @param string|null     $valueName
     * @param array<int,string>|null   $errors
     * @param string|null     $message
     * @param \Throwable|null $previous
     */
    public function __construct(
        ?string $constraintClassName,
        mixed $value,
        ?string $valueName,
        ?array $errors,
        ?string $message,
        ?\Throwable $previous = null
    ) {
        $con = Format::toString($constraintClassName);
        $val = Format::toString($value);
        $nam = (null === $valueName || '' === $valueName) ? '' : '. name=[' . $valueName . ']';
        $msg = (null === $message || '' === $message) ? '' : ': ' . $message;

        $message = 'Constraint [' . $con . '] violated' . $msg . '. ' . $nam . '. value=[' . $val
            . ']. errors=[' . (null === $errors ? 0 : \count($errors)) . ']. messages=[' . \implode(',', $errors) . ']';

        parent::__construct($message, 0, $previous);
    }
}
