<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsSlackUsername.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * @psalm-immutable
 */
class IsSlackUsername extends AbstractSimpleConstraint
{
//    public const REGEX = '/^[@#]?[a-zA-Z][a-zA-Z 0-9._-]*$/';
    public const REGEX = '/^[@#]?[a-zA-Z][a-zA-Z \d._-]*$/';

    /**
     * @inheritDoc
     */
    public static function isValid(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        if (\is_string($value) && (1 === \preg_match(self::REGEX, $value))) {
            return true;
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage(
                $value,
                $valueName,
                'Slack user name expected matching regex [%s]',
                self::REGEX
            );
        }
        return false;
    }
}
