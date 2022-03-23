<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsUrl.php
 * Class name...: IsUrl.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\constraints\parameterized;

use iomywiab\iomywiab_php_constraints\AbstractConstraint;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsIntegerArrayOrNull;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringArrayOrNull;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\Format;

/**
 * Class Url
 *
 * @package iomywiab\iomywiab_php_constraints
 */
class IsUrl extends AbstractConstraint
{
    private const SERIALIZE_SCHEMES = 1;
    private const SERIALIZE_HOSTS = 2;
    private const SERIALIZE_PORTS = 3;

    /**
     * @var string[]|null
     */
    private $schemes;

    /**
     * @var string[]|null
     */
    private $hosts;

    /**
     * @var int[]|null
     */
    private $ports;

    /**
     * Url constructor.
     *
     * @param string[]|null $schemes
     * @param string[]|null $hosts
     * @param int[]|null    $ports
     * @throws ConstraintViolationException
     */
    public function __construct(?array $schemes = null, ?array $hosts = null, ?array $ports = null)
    {
        IsStringArrayOrNull::assert($schemes);
        IsStringArrayOrNull::assert($hosts);
        IsIntegerArrayOrNull::assert($ports);
        $this->schemes = $schemes;
        $this->hosts = $hosts;
        $this->ports = $ports;
    }

    /**
     * @param string[]|null $schemes
     * @return IsUrl
     * @throws ConstraintViolationException
     */
    public function setSchemes(?array $schemes): self
    {
        IsStringArrayOrNull::assert($schemes);

        $this->schemes = $schemes;

        return $this;
    }

    /**
     * @param string[]|null $hosts
     * @return IsUrl
     * @throws ConstraintViolationException
     */
    public function setHosts(?array $hosts): self
    {
        IsStringArrayOrNull::assert($hosts);

        $this->hosts = $hosts;

        return $this;
    }

    /**
     * @param int[]|null $ports
     * @return IsUrl
     * @throws ConstraintViolationException
     */
    public function setPorts(?array $ports): self
    {
        IsIntegerArrayOrNull::assert($ports);

        $this->ports = $ports;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isValidValue($value, ?string $valueName = null, array &$errors = null): bool
    {
        return static::isValid($value, $valueName, $this->schemes, $this->hosts, $this->ports, $errors);
    }

    /**
     * @param               $value
     * @param string|null   $valueName
     * @param string[]|null $schemes
     * @param string[]|null $hosts
     * @param int[]|null    $ports
     * @param array|null    $errors
     * @return bool
     * @noinspection PhpTooManyParametersInspection
     */
    public static function isValid(
        $value,
        ?string $valueName = null,
        ?array $schemes = null,
        ?array $hosts = null,
        ?array $ports = null,
        array &$errors = null
    ): bool {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        if (false !== \filter_var($value, FILTER_VALIDATE_URL)) {
            $isValid = true;
            if (isset($schemes) || isset($hosts) || isset($ports)) {
                /** @noinspection PhpFullyQualifiedNameUsageInspection */
                $parts = \parse_url($value);
                /** @noinspection PhpFullyQualifiedNameUsageInspection */
                if (isset($schemes) && isset($parts['scheme']) && !\in_array($parts['scheme'], $schemes)) {
                    $isValid = false;
                } /** @noinspection PhpFullyQualifiedNameUsageInspection */
                elseif (isset($hosts) && isset($parts['host']) && !\in_array($parts['host'], $hosts)) {
                    $isValid = false;
                } /** @noinspection PhpFullyQualifiedNameUsageInspection */
                elseif (isset($ports) && isset($parts['port']) && !\in_array($parts['port'], $ports)) {
                    $isValid = false;
                }
            }
            if ($isValid) {
                return true;
            }
        }

        if (null !== $errors) {
            /** @noinspection PhpFullyQualifiedNameUsageInspection */
            if (false === \filter_var($value, FILTER_VALIDATE_URL)) {
                $errors[] = self::toErrorMessage($value, $valueName, 'URL expected');
            } else {
                self::addDetailErrors($value, $valueName, $schemes, $hosts, $ports, $errors);
            }
        }

        return false;
    }

    /**
     * @param             $value
     * @param string|null $valueName
     * @param array|null  $schemes
     * @param array|null  $hosts
     * @param array|null  $ports
     * @param array       $errors
     * @noinspection PhpTooManyParametersInspection
     */
    protected static function addDetailErrors(
        $value,
        ?string $valueName,
        ?array $schemes,
        ?array $hosts,
        ?array $ports,
        array &$errors
    ) {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        $parts = \parse_url($value);
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        if (isset($schemes) && isset($parts['scheme']) && !\in_array($parts['scheme'], $schemes)) {
            $format = 'Scheme [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toValueList($schemes));
        }
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        if (isset($hosts) && isset($parts['host']) && !\in_array($parts['host'], $hosts)) {
            $format = 'Host [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toValueList($hosts));
        }
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        if (isset($ports) && isset($parts['port']) && !\in_array($parts['port'], $ports)) {
            $format = 'Port [%s] expected';
            $errors[] = self::toErrorMessage($value, $valueName, $format, Format::toValueList($ports));
        }
    }

    /**
     * @inheritDoc
     */
    public function assertValue($value, ?string $valueName = null, ?string $message = null): void
    {
        static::assert($value, $valueName, $this->schemes, $this->hosts, $this->ports, $message);
    }

    /**
     * @param               $value
     * @param string|null   $valueName
     * @param string[]|null $schemes
     * @param string[]|null $hosts
     * @param int[]|null    $ports
     * @param string|null   $message
     * @noinspection PhpTooManyParametersInspection
     * @throws ConstraintViolationException
     */
    public static function assert(
        $value,
        ?string $valueName = null,
        ?array $schemes = null,
        ?array $hosts = null,
        ?array $ports = null,
        ?string $message = null
    ): void {
        $errors = [];
        if (!static::isValid($value, $valueName, $schemes, $hosts, $ports, $errors)) {
            throw new ConstraintViolationException(static::class, $value, $valueName, $errors, $message);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        return \serialize(
            [
                /** @noinspection PhpFullyQualifiedNameUsageInspection */
                self::SERIALIZE_SCHEMES => \serialize($this->schemes),
                /** @noinspection PhpFullyQualifiedNameUsageInspection */
                self::SERIALIZE_HOSTS   => \serialize($this->hosts),
                /** @noinspection PhpFullyQualifiedNameUsageInspection */
                self::SERIALIZE_PORTS   => \serialize($this->ports),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data): void
    {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        $items = \unserialize($data);
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        $this->schemes = \unserialize($items[self::SERIALIZE_SCHEMES]);
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        $this->hosts = \unserialize($items[self::SERIALIZE_HOSTS]);
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        $this->ports = \unserialize($items[self::SERIALIZE_PORTS]);
    }

    public function __serialize(): array
    {
        return [$this->schemes, $this->hosts, $this->ports];
    }

    public function __unserialize(array $data): void
    {
        $this->schemes = $data[0];
        $this->hosts = $data[1];
        $this->ports = $data[2];
    }

}