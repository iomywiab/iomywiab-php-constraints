<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsSlackUsername.php
 * Class name...: IsSlackUsername.php
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
class IsSlackUsername extends AbstractSimpleConstraint
{
    public const REGEX = '/^[@#]?[a-zA-Z][a-zA-Z 0-9._-]*$/';

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
                'Slack user name expected matching regex [%s]',
                self::REGEX
            );
        }
        return false;
    }
}