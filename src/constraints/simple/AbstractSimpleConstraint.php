<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractSimpleConstraint.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\interfaces\SimpleConstraintInterface;

/**
 * @psalm-immutable
 */
abstract class AbstractSimpleConstraint extends AbstractConstraint implements SimpleConstraintInterface
{
    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($value, $valueName, $errors);
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($value, $valueName, $message);
    }

    /**
     * @inheritDoc
     */
    public static function assert(mixed $value, ?string $valueName = null, ?string $message = null): void
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
        return \serialize(null);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        // no code
    }

    /**
     * Even though this method actually does nothing it is required to avoid PHP 8 error warnings.
     * @return array
     * @noinspection SenselessMethodDuplicationInspection
     */
    public function __serialize(): array
    {
        return [];
    }

    /**
     * Even though this method actually does nothing it is required to avoid PHP 8 error warnings.
     * @param array $data
     * @return void
     * @noinspection SenselessMethodDuplicationInspection
     */
    public function __unserialize(array $data): void
    {
        // no code
    }
}
