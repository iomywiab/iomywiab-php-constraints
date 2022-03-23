<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsDomain.php
 * Class name...: IsDomain.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * Class Url
 * @package iomywiab\iomywiab_php_constraints
 */
class IsDomain extends AbstractSimpleConstraint
{
    public const REGEX = '/^(?!\-)(?:(?:[a-zA-Z\d][a-zA-Z\d\-]{0,61})?[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/';

    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        if (\is_string($value) && (1 == \preg_match(self::REGEX, $value))) {
            return true;
        }

        if (null !== $errors) {
            $errors[] = self::toErrorMessage(
                $value,
                $valueName,
                'Internet domain name expected matching regex [%s]',
                self::REGEX
            );
        }
        return false;
    }

}