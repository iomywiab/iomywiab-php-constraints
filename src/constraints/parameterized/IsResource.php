<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsResource.php
 * Class name...: IsResource.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;

/**
 * Class Numeric
 * @package iomywiab\iomywiab_php_constraints
 */
class IsResource extends AbstractConstraint
{
    /**
     * @var string
     */
    private $resourceType;

    /**
     * IsResource constructor.
     * @param string|null $type
     */
    public function __construct(?string $type = null)
    {
        $this->resourceType = $type;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($value, $valueName, $this->resourceType, $errors);
    }

    /**
     * @param             $value
     * @param string|null $valueName
     * @param string|null $type
     * @param array|null  $errors
     * @return bool
     */
    public static function isValid($value, ?string $valueName = null, ?string $type = null, array &$errors = null): bool
    {
        if (is_resource($value) && ((null === $type) || ($type == get_resource_type($value)))) {
            return true;
        }

        if (null !== $errors) {
            $expected = empty($type) ? 'any' : $type;
            $actual = is_resource($value) ? get_resource_type($value) : 'none';
            $format = 'Resource of type [%s] expected. Got resource type [%s]';
            $errors[] = self::toErrorMessage($value, $valueName, $format, $expected, $actual);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($value, $valueName, $this->resourceType, $message);
    }

    /**
     * @param             $value
     * @param string|null $valueName
     * @param string|null $type
     * @param string|null $message
     * @throws ConstraintViolationException
     */
    public static function assert(
        $value,
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
        return serialize($this->resourceType);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->resourceType = unserialize($data);
    }

    public function __serialize(): array
    {
        return [$this->resourceType];
    }

    public function __unserialize(array $data): void
    {
        $this->resourceType = $data[0];
    }

}