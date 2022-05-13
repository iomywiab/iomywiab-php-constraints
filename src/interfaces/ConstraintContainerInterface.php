<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ConstraintContainerInterface.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\interfaces;

use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 */
interface ConstraintContainerInterface extends ConstraintInterface
{
    /**
     * @param ConstraintInterface|array<array-key,ConstraintInterface>|null $constraints
     * @return ConstraintContainerInterface
     * @throws ConstraintViolationException
     */
    public function add(ConstraintInterface|array|null $constraints): ConstraintContainerInterface;
}
