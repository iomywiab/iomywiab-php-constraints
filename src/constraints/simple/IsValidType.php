<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsValidType.php
 * Class name...: IsValidType.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class IsValidType
 * @package iomywiab\iomywiab_php_constraints\simple
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
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if (is_string($value) && in_array($value, self::ALL_TYPES)) {
            return true;
        }

        if (null !== $errors) {
            $list = Format::toValueList(self::ALL_TYPES);
            $errors[] = self::toErrorMessage($value, $valueName, 'Type name [%s] expected', $list);
        }
        return false;
    }
}