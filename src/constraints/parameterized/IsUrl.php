<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsUrl.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsIntegerArrayOrNull;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringArrayOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\formatter\complex\Format;

/**
 * @psalm-immutable
 */
class IsUrl extends AbstractConstraint
{
    private const SERIALIZE_SCHEMES = 1;
    private const SERIALIZE_HOSTS = 2;
    private const SERIALIZE_PORTS = 3;

    /**
     * @param array<int,string>|null $schemes
     * @param array<int,string>|null $hosts
     * @param array<int,int>|null    $ports
     * @throws ConstraintViolationException
     */
    public function __construct(
        private /* readonly (but serializable) */ ?array $schemes = null,
        private /* readonly (but serializable) */ ?array $hosts = null,
        private /* readonly (but serializable) */ ?array $ports = null
    ) {
        IsStringArrayOrNull::assert($schemes);
        IsStringArrayOrNull::assert($hosts);
        IsIntegerArrayOrNull::assert($ports);
    }

    /**
     * @inheritDoc
     */
    public function isValidValue(mixed $value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($value, $valueName, $this->schemes, $this->hosts, $this->ports, $errors);
    }

    /**
     * @param mixed                  $value
     * @param array<int,string>|null $schemes
     * @param array<int,string>|null $hosts
     * @param array<int,int>|null    $ports
     * @param string|null            $valueName
     * @param array<int,string>|null $errors
     * @return bool
     * @noinspection PhpTooManyParametersInspection
     * @noinspection OffsetOperationsInspection
     */
    public static function isValid(
        mixed $value,
        ?array $schemes = null,
        ?array $hosts = null,
        ?array $ports = null,
        ?string $valueName = null,
        array &$errors = null
    ): bool {
        if (false !== \filter_var($value, FILTER_VALIDATE_URL)) {
            $isValid = true;
            if (isset($schemes) || isset($hosts) || isset($ports)) {
                $parts = \parse_url($value);
                if (isset($schemes, $parts['scheme']) && !\in_array($parts['scheme'], $schemes, true)) {
                    $isValid = false;
                } elseif (isset($hosts, $parts['host']) && !\in_array($parts['host'], $hosts, true)) {
                    $isValid = false;
                } elseif (isset($ports, $parts['port']) && !\in_array($parts['port'], $ports, true)) {
                    $isValid = false;
                }
            }
            if ($isValid) {
                return true;
            }
        }

        if (null !== $errors) {
            if (false !== \filter_var($value, FILTER_VALIDATE_URL)) {
                self::addDetailErrors($value, $schemes, $hosts, $ports, $valueName, $errors);
            } else {
                $errors[] = self::toErrorMessage($value, $valueName, 'URL expected');
            }
        }

        return false;
    }

    /**
     * @param mixed                  $value
     * @param array<int,string>|null $schemes
     * @param array<int,string>|null $hosts
     * @param array<int,int>|null    $ports
     * @param string|null            $valueName
     * @param array<int,string>      $errors
     * @noinspection PhpTooManyParametersInspection
     * @noinspection OffsetOperationsInspection
     */
    protected static function addDetailErrors(
        mixed $value,
        ?array $schemes,
        ?array $hosts,
        ?array $ports,
        ?string $valueName,
        array &$errors
    ): void {
        $parts = \parse_url($value);
        if (isset($schemes, $parts['scheme']) && !\in_array($parts['scheme'], $schemes, true)) {
            $format = 'Scheme [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toValueList($schemes));
        }
        if (isset($hosts, $parts['host']) && !\in_array($parts['host'], $hosts, true)) {
            $format = 'Host [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toValueList($hosts));
        }
        if (isset($ports, $parts['port']) && !\in_array($parts['port'], $ports, true)) {
            $format = 'Port [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toValueList($ports));
        }
    }

    /**
     * @inheritDoc
     */
    public function assertValue(mixed $value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($value, $this->schemes, $this->hosts, $this->ports, $valueName, $message);
    }

    /**
     * @param mixed                  $value
     * @param array<int,string>|null $schemes
     * @param array<int,string>|null $hosts
     * @param array<int,int>|null    $ports
     * @param string|null            $valueName
     * @param string|null            $message
     * @noinspection PhpTooManyParametersInspection
     * @throws ConstraintViolationException
     */
    public static function assert(
        mixed $value,
        ?array $schemes = null,
        ?array $hosts = null,
        ?array $ports = null,
        ?string $valueName = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($value, $schemes, $hosts, $ports, $valueName, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize(
            [
                self::SERIALIZE_SCHEMES => \serialize($this->schemes),
                self::SERIALIZE_HOSTS => \serialize($this->hosts),
                self::SERIALIZE_PORTS => \serialize($this->ports),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function unserialize(mixed $data): void
    {
        $items = \unserialize($data, ['allowed_class' => false]);
        $this->schemes = \unserialize($items[self::SERIALIZE_SCHEMES], ['allowed_class' => false]);
        $this->hosts = \unserialize($items[self::SERIALIZE_HOSTS], ['allowed_class' => false]);
        $this->ports = \unserialize($items[self::SERIALIZE_PORTS], ['allowed_class' => false]);
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [$this->schemes, $this->hosts, $this->ports];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->schemes = $data[0];
        $this->hosts = $data[1];
        $this->ports = $data[2];
    }
}
