<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractConstraintContainer.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/combined/AbstractConstraintContainer.php
 * Class name...: AbstractConstraintContainer.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:37:29
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractConstraintContainer.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/src/constraints/combined/AbstractConstraintContainer.php
 * Class name...: AbstractConstraintContainer.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:36
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\combined;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsImplementingInterface;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\interfaces\ConstraintContainerInterface;
use iomywiab\iomywiab_php_constraints\interfaces\ConstraintInterface;

/**
 * Class AbstractConstraintContainer
 * @package iomywiab\iomywiab_php_constraints
 */
class AbstractConstraintContainer extends AbstractConstraint implements ConstraintContainerInterface
{
    /**
     * @var ConstraintInterface[]
     */
    protected $constraints = [];

    /**
     * AbstractConstraintContainer constructor.
     * @param ConstraintInterface|ConstraintInterface[]|null $constraints
     * @throws ConstraintViolationException
     */
    public function __construct($constraints = null)
    {
        $this->add($constraints);
    }

    /**
     * @inheritDoc
     */
    public function add($constraints): ConstraintContainerInterface
    {
        if (empty($constraints)) {
            return $this;
        }

        $addMultiple = is_array($constraints);
        if (!$addMultiple) {
            $constraints = [$constraints];
        }

        foreach ($constraints as $constraint) {
            IsImplementingInterface::assert(ConstraintInterface::class, $constraint);
        }

        if (empty($this->constraints)) {
            $this->constraints = $constraints;
        } else {
            foreach ($constraints as $key => $constraint) {
                if (is_int($key) && (0 > $key)) {
                    // if a pre-defined key is specified then we use it
                    $this->constraints[$key] = $constraint;
                } else {
                    // all other keys have no effect. Order of appearance is important
                    $this->constraints[] = $constraint;
                }
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->constraints, $value, $valueName, $errors);
//        try {
//            return static::isValid($this->constraints, $value, $valueName, $errors);
//
//            // the following code block should never get executed, not even by code coverage tests.
//            // @codeCoverageIgnoreStart
//        } catch (ConstraintViolationException $cause) {
//            throw new LogicException($cause->getMessage(), $cause);
//            // @codeCoverageIgnoreEnd
//        }
    }

    /**
     * @param ConstraintInterface[] $constraints
     * @param                       $value
     * @param string|null           $valueName
     * @param array|null            $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(array $constraints, $value, ?string $valueName = null, array &$errors = null): bool
    {
        $isValid = true;
        if (!empty($constraints)) {
            foreach ($constraints as $constraint) {
                if (!IsImplementingInterface::isValid(ConstraintInterface::class, $constraint)
                    || !$constraint->isValidValue($value)) {
                    $isValid = false;
                    break;
                }
            }
        }

        if ($isValid) {
            return true;
        }

        if (null !== $errors) {
            foreach ($constraints as $constraint) {
                $constraint->isValidValue($value, $valueName, $errors);
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->constraints, $value, $valueName, $message);
    }

    /**
     * @param array       $constraints
     * @param             $value
     * @param string|null $valueName
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(array $constraints, $value, ?string $valueName = null, ?string $message = null): void
    {
        $errors = [];
        if (!static::isValid($constraints, $value, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        $items = [];
        if (!empty($this->constraints)) {
            foreach ($this->constraints as $key => $constraint) {
                $items[$key] = serialize($constraint);
            }
        }
        return serialize($items);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data): void
    {
        $this->constraints = [];
        $items = unserialize($data);
        if (!empty($items)) {
            foreach ($items as $key => $constraint) {
                $this->constraints[$key] = unserialize($constraint);
            }
        }
    }

}