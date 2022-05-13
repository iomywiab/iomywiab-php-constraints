<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsPropertyExists.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsPropertyExists extends AbstractObjectOrClassnameConstraint
{
    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public static function isValid(
        object|string $objectOrClass,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if (\is_string($value) && \property_exists($objectOrClass, $value)) {
            return true;
        }

        if (null !== $errors) {
            $format = 'Property of class [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toString($objectOrClass));
        }
        return false;
    }
}
