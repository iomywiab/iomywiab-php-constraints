<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ConstraintViolationException.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/exceptions/ConstraintViolationException.php
 * Class name...: ConstraintViolationException.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:58:01
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ConstraintViolationException.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/exceptions/ConstraintViolationException.php
 * Class name...: ConstraintViolationException.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:37
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\exceptions;

use iomywiab\iomywiab_php_constraints\Format;
use LogicException;
use Throwable;

/**
 * Class ConstraintViolationException
 *
 * Formerly based on InvalidArgumentException, now derived from LogicException
 * InvalidArgumentException extends LogicException and signals programming errors
 * UnexpectedValueException extends RuntimeException and signals values from user or config.
 *
 * @package iomywiab\iomywiab_php_constraints\exceptions
 */
class ConstraintViolationException extends LogicException
{
    /**
     * ConstraintViolationException constructor.
     * @param string|null                                              $constraintClassName
     * @param                                                          $value
     * @param string|null                                              $valueName
     * @param string[]|null                                            $errors
     * @param string|null                                              $message
     * @param Throwable|null                                           $previous
     */
    public function __construct(
        ?string $constraintClassName,
        $value,
        ?string $valueName,
        ?array $errors,
        ?string $message,
        ?Throwable $previous = null
    ) {
        parent::__construct(
            static::createMessage($constraintClassName, $value, $valueName, $errors, $message),
            0,
            $previous
        );
    }

    /**
     * @param string|null              $constraintClassName
     * @param                          $value
     * @param string|null              $valueName
     * @param string[]|null            $errors
     * @param string|null              $message
     * @return string
     */
    private static function createMessage(
        ?string $constraintClassName,
        $value,
        ?string $valueName,
        ?array $errors,
        ?string $message
    ): string {
        $con = Format::toString($constraintClassName);
        $val = Format::toString($value);
        $nam = empty($valueName) ? '' : '. name=[' . $valueName . ']';
        $msg = empty($message) ? '' : ': ' . $message;

        return 'Constraint [' . $con . '] violated' . $msg . '. ' . $nam . '. value=[' . $val
            . ']. errors=[' . count($errors) . ']. messages=[' . implode(',', $errors) . ']';
    }

}
