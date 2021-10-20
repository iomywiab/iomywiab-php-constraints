<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsDirectory.php
 * Class name...: IsDirectory.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\simple;

/**
 * Class Enum
 * @package iomywiab\iomywiab_php_constraints
 */
class IsDirectory extends AbstractSimpleConstraint
{
    /**
     * @inheritDoc
     */
    public static function isValid($value, ?string $valueName = null, array &$errors = null): bool
    {
        if (is_string($value) && is_dir($value)) {
            return true;
        }

        if (null !== $errors) {
            $message = is_string($value) && file_exists($value) ? 'Directory not found' : 'Is not a directory';
            $errors[] = self::toErrorMessage($value, $valueName, $message);
        }
        return false;
    }

}