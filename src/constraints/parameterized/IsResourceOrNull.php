<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsResourceOrNull.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * @psalm-immutable
 */
class IsResourceOrNull extends IsResource
{
    /**
     * @inheritDoc
     */
    public static function isValid(
        mixed $value,
        ?string $valueName = null,
        ?string $type = null,
        array &$errors = null
    ): bool {
        if ((null === $value) || parent::isValid($value, $valueName, $type)) {
            return true;
        }

        if (null !== $errors) {
            $expected = (null === $type || '' === $type) ? 'any' : $type;
            $actual = \is_resource($value) ? \get_resource_type($value) : 'none';
            $format = 'Resource of type [%s] or null expected. Got resource type [%s]';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $expected, $actual);
        }
        return false;
    }
}
