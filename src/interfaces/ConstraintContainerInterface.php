<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ConstraintContainerInterface.php
 * Class name...: ConstraintContainerInterface.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\interfaces;

use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Interface ConstraintContainerInterface
 * @package iomywiab\iomywiab_php_constraints\interfaces
 */
interface ConstraintContainerInterface extends ConstraintInterface
{

    /**
     * @param ConstraintInterface|ConstraintInterface[] $constraints
     * @return ConstraintContainerInterface
     * @throws ConstraintViolationException
     */
    public function add($constraints): ConstraintContainerInterface;

}