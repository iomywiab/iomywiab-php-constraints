<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsResource.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * @psalm-immutable
 */
class IsResource extends AbstractConstraint
{
    /**
     * IsResource constructor.
     * @param string|null $resourceType
     */
    public function __construct(private /*readonly (but serializable)*/ ?string $resourceType = null)
    {
        // no code
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($value, $valueName, $this->resourceType, $errors);
    }

    /**
     * @param mixed                  $value
     * @param string|null            $valueName
     * @param string|null            $type
     * @param array<int,string>|null $errors
     * @return bool
     */
    public static function isValid(
        mixed $value,
        ?string $valueName = null,
        ?string $type = null,
        array &$errors = null
    ): bool {
        if (\is_resource($value) && ((null === $type) || ($type === \get_resource_type($value)))) {
            return true;
        }

        if (null !== $errors) {
            $expected = (null === $type || '' === $type) ? 'any' : $type;
            $actual = \is_resource($value) ? \get_resource_type($value) : 'none';
            $format = 'Resource of type [%s] expected. Got resource type [%s]';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $expected, $actual);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($value, $valueName, $this->resourceType, $message);
    }

    /**
     * @param mixed       $value
     * @param string|null $valueName
     * @param string|null $type
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        mixed $value,
        ?string $valueName = null,
        ?string $type = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($value, $valueName, $type, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize($this->resourceType);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $this->resourceType = \unserialize($data, ['allowed_class' => false]);
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [$this->resourceType];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->resourceType = $data[0];
    }
}
