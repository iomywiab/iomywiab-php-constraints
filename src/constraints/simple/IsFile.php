<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsFile.php
 * Class name...: IsFile.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints;

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * Class Enum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsFile extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        if (\is_string($value) && \is_file($value)) {
            return true;
        }

        if (null !== $errors) {
            /** @noinspection PhpFullyQualifiedNameUsageInspection */
            $message = \is_string($value) && \file_exists($value) ? 'File not found' : 'Is not a file';
            $errors[] = self::toErrorMessage($value, $valueName, $message);
        }
        return false;
    }

}