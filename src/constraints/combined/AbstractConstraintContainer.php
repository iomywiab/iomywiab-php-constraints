<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractConstraintContainer.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\combined;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsImplementingInterface;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\interfaces\ConstraintContainerInterface;
use iomywiab\iomywiab_php_constraints\interfaces\ConstraintInterface;

/**
 * @psalm-immutable
 */
class AbstractConstraintContainer extends AbstractConstraint implements ConstraintContainerInterface
{
    /**
     * @var array<int,ConstraintInterface>|null
     */
    protected ?array $constraints;

    /**
     * AbstractConstraintContainer constructor.
     *
     * @param ConstraintInterface|array<array-key,ConstraintInterface>|null $constraints
     * @throws ConstraintViolationException
     */
    public function __construct(array|ConstraintInterface|null $constraints = null)
    {
        if (null !== $constraints) {
            $this->add($constraints);
        }
    }

    /**
     * @inheritDoc
     */
    public function add(ConstraintInterface|array|null $constraints): ConstraintContainerInterface
    {
        if ((null === $constraints) || ([] === $constraints)) {
            return $this;
        }

        $addMultiple = \is_array($constraints);
        if (!$addMultiple) {
            $constraints = [$constraints];
        }

        /** @var array<int,ConstraintInterface> $constraints */
        foreach ($constraints as $constraint) {
            IsImplementingInterface::assert(ConstraintInterface::class, $constraint);
        }

        if (isset($this->constraints)) {
            foreach ($constraints as $key => $constraint) {
                if (\is_int($key) && (0 > $key)) {
                    // if a pre-defined key is specified then we use it
                    $this->constraints[$key] = $constraint;
                } else {
                    // all other keys have no effect. Order of appearance is important
                    $this->constraints[] = $constraint;
                }
            }
            return $this;
        }

        $this->constraints = $constraints;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($this->constraints ?? null, $value, $valueName, $errors);
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
     * @param array<int,ConstraintInterface>|null $constraints
     * @param mixed                               $value
     * @param string|null                         $valueName
     * @param array<int,string>|null              $errors
     * @return bool
     * @throws ConstraintViolationException
     */
    public static function isValid(
        ?array $constraints,
        mixed $value,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        $isValid = true;
        if (isset($constraints)) {
            foreach ($constraints as $constraint) {
                if (
                    !IsImplementingInterface::isValid(ConstraintInterface::class, $constraint)
                    || !$constraint->isValidValue($value)
                ) {
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
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($this->constraints ?? null, $value, $valueName, $message);
    }

    /**
     * @param array<int,ConstraintInterface>|null $constraints
     * @param mixed                               $value
     * @param string|null                         $valueName
     * @param string|null                         $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        ?array $constraints,
        mixed $value,
        ?string $valueName = null,
        ?string $message = null
    ): void {
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
        if (isset($this->constraints)) {
            foreach ($this->constraints as $key => $constraint) {
                $items[$key] = serialize($constraint);
            }
        }
        return serialize($items);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->constraints = [];
        $items = unserialize($data, ['allowed_class' => false]);
        if (null !== $items) {
            foreach ($items as $key => $constraint) {
                $this->constraints[$key] = unserialize($constraint, ['allowed_class' => true]);
            }
        }
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return $this->constraints ?? [];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->constraints = $data;
    }
}
