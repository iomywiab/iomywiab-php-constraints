<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractSimpleConstraint.php
 * Class name...: AbstractSimpleConstraint.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\interfaces\SimpleConstraintInterface;

/**
 * Class AbstractConstraint
 * @package iomywiab\iomywiab_php_constraints
 */
abstract class AbstractSimpleConstraint extends AbstractConstraint implements SimpleConstraintInterface
{

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($value, $valueName, $errors);
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($value, $valueName, $message);
    }

    /**
     * @inheritDoc
     */
    public static function assert($value, ?string $valueName = null, ?string $message = null): void
    {
        $errors = [];
        if (!static::isValid($value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize(null);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        // no code
    }

    public function __serialize(): array {
        return [];
    }

    public function __unserialize(array $data): void {
        // no code
    }
}