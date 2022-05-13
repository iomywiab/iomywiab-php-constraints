<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsArrayMaxCount.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

/**
 * @psalm-immutable
 */
class IsArrayMaxCount extends AbstractMaximumIntConstraint
{
    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public static function isValid(
        int $maximum,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        IsGreaterOrEqual::assert(0, $maximum);

        if (\is_array($value) && ($maximum >= \count($value))) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Array with a maximum number of items [%d] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $maximum);
        }
        return false;
    }
}
