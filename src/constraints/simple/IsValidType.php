<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsValidType.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsValidType extends AbstractSimpleConstraint
{
    public const BOOL = 'boolean';
    public const INT = 'integer';
    public const FLOAT = 'double';
    public const STRING = 'string';
    public const ARRAY = 'array';
    public const OBJECT = 'object';

    public const ALL_TYPES = [self::BOOL, self::INT, self::FLOAT, self::STRING, self::ARRAY, self::OBJECT];

    /**
     * @inheritDoc
     */
    public static function isValid(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        if (\is_string($value) && \in_array($value, self::ALL_TYPES, true)) {
            return true;
        }

        if (null !== $errors) {
            $list = Format::toValueList(self::ALL_TYPES);
            $errors[] = self::toErrorMessage($value, $valueName, 'Type name [%s] expected', $list);
        }
        return false;
    }
}
