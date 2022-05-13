<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ArrayKeyFormatting.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

/** @noinspection EmptyClassInspection */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\complex;

/**
 * @psalm-immutable
 */
enum ArrayKeyFormatting
{
case INCLUDE_KEYS;
case EXCLUDE_KEYS;
case INCLUDE_KEYS_IF_NO_LIST;
    }
