<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: Format.php
 * Class name...: Format.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:00
 */
/** @noinspection PhpUnused */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints;

use DateTime;
use DateTimeImmutable;
use Exception;
use ReflectionClass;

/**
 * Class Format
 * @package iomywiab\iomywiab_php_constraints
 */
class Format
{
    public const NULL_STRING = 'null';
    public const TRUE_STRING = 'true';
    public const FALSE_STRING = 'false';
    public const NOT_AVAILABLE = 'n/a';

    public const DEFAULT_MAX_LENGTH = null;

    /**
     * @param array|null $values
     * @param int|null   $maxLength
     * @return string
     */
    public static function toValueList(?array $values, ?int $maxLength = self::DEFAULT_MAX_LENGTH): string
    {
        if (empty($values)) {
            return '';
        } else {
            $return = '';
            $separator = '';
            foreach ($values as $value) {
                // Pls note: implode is unable to handle arrays
                $return .= $separator . self::toString($value, null);
                $separator = '|';
            }
            return self::toReducedString($return, $maxLength);
        }
    }

    /**
     * Delimiter matrix:
     * | useDelimiter | array | string | others |
     * | ------------ | ----- | ------ | ------ |
     * | null         | []    |        |        |
     * | true         | []    | ""     |        |
     * | false        |       |        |        |
     *
     * @param mixed     $value
     * @param int|null  $maxLength
     * @param bool|null $useTypeDelimiters
     * @return string
     */
    public static function toString(
        $value,
        ?int $maxLength = self::DEFAULT_MAX_LENGTH,
        ?bool $useTypeDelimiters = null
    ): string {
        if (null === $value) {
            $return = self::NULL_STRING;
        } elseif (true === $value) {
            $return = self::TRUE_STRING;
        } elseif (false === $value) {
            $return = self::FALSE_STRING;
        } elseif (is_array($value)) {
            if (false !== $useTypeDelimiters) {
                $return = '[';
                $endDelimiter = ']';
            } else {
                $return = '';
            }
            if (!empty($value)) {
                $separator = '';
                $count = 0;
                $hideKey = true;
                foreach ($value as $key => $item) {
                    if ($hideKey) {
                        $hideKey = ($count === $key);
                        $count++;
                    }
                    $return .= ($hideKey)
                        ? $separator . self::toString($item, null, true)
                        : $separator . self::toString($key, null, true) . '=>' . self::toString($item, null, true);
                    $separator = ',';
                }
            }
        } elseif (is_object($value)) {
            $return = self::toShortClassName($value);

            if (method_exists($value, '__toString')) {
                $return .= ':[' . $value->__toString() . ']';
            } elseif ($value instanceof DateTime || $value instanceof DateTimeImmutable) {
                $return .= ':[' . $value->format('c') . ']';
            }
        } elseif (is_string($value)) {
            if (true === $useTypeDelimiters) {
                $return = '"' . $value;
                $endDelimiter = '"';
            } else {
                $return = $value;
            }
        } elseif (is_resource($value)) {
            $return = get_resource_type($value);
        } else {
            $return = (string)$value;
        }

        return isset($endDelimiter)
            ? self::toReducedString($return, (null === $maxLength) ? null : $maxLength - 1) . $endDelimiter
            : self::toReducedString($return, $maxLength);
    }

    /**
     * @param mixed $object
     * @return string
     */
    public static function toShortClassName($object): string
    {
        try {
            if (is_string($object) || is_object(($object))) {
                return (new ReflectionClass($object))->getShortName();
            }
        } catch (Exception $ignore) {
            // no code
        }
        return self::toType($object);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function toType($value): string
    {
        if (null === $value) {
            return self::NULL_STRING;
        }
        return is_object($value) ? get_class($value) : gettype($value);
    }

    /**
     * @param string|null $string
     * @param int|null    $maxLength
     * @return string
     */
    public static function toReducedString(?string $string, ?int $maxLength = self::DEFAULT_MAX_LENGTH): string
    {
        if (null === $string) {
            return self::NULL_STRING;
        }

        if ((null === $maxLength) || (3 >= $maxLength)) {
            return $string;
        }
        $length = strlen($string);
        return ($length <= $maxLength)
            ? $string
            : substr($string, 0, $maxLength - 3) . '...';
    }

    /**
     * @param mixed $object
     * @return string
     */
    public static function toClassName($object): string
    {
        try {
            if (is_string($object) || is_object(($object))) {
                return (new ReflectionClass($object))->getName();
            }
        } catch (Exception $ignore) {
            // no code
        }
        return self::toType($object);
    }

    /**
     * @param             $value
     * @param string|null $valueName
     * @param string      $format use by vsprintf()
     * @return string
     * @see AbstractConstraint::toErrorMessage()
     * @noinspection SpellCheckingInspection
     */
    public static function toErrorMessage($value, ?string $valueName, string $format): string
    {
        $num = func_num_args();
        if (3 < $num) {
            $arguments = func_get_args();
            unset($arguments[2]); // format
            unset($arguments[1]); // valueName
            unset($arguments[0]); // value
            $format = vsprintf($format, $arguments);
        }
        return (empty($valueName) ? '' : $valueName . ': ')
            . $format
            . '. Got ' . self::toDescription($value);
    }

    /**
     * @param mixed    $value
     * @param int|null $maxLength
     * @return string
     */
    public static function toDescription($value, ?int $maxLength = self::DEFAULT_MAX_LENGTH): string
    {
        if (null === $value) {
            // there is no way to shorten null so we do not care about maxlength
            return self::NULL_STRING;
        }

        if (is_object($value)) {
            return self::toReducedString('object:' . self::toString($value), $maxLength);
        }

        $val = '[' . self::toString($value, null, is_string($value));
        $type = self::toType($value);

        if (null === $maxLength) {
            return $type . ':' . $val . ']';
        }

        $typeLength = strlen($type);

        return ($typeLength + 2 >= $maxLength)
            ? self::toReducedString($type, $maxLength)
            : self::toReducedString($type . ':' . $val . ']', $maxLength);
    }


}