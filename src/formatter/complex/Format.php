<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: Format.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\complex;

use iomywiab\iomywiab_php_constraints\formatter\scalar\StringFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\LengthFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\TypeFormatter;

/**+
 * @psalm-immutable
 */
class Format implements FormatInterface
{
    private static ?ItemFormatterInterface $standardFormatter = null;
    private static ?ItemFormatterInterface $debugFormatter = null;
    private static ?ArrayFormatterInterface $listFormatter = null;

    /**
     * @return ItemFormatterInterface
     */
    protected static function getStandardFormatter(): ItemFormatterInterface
    {
        if (null === self::$standardFormatter) {
            self::$standardFormatter = new ItemFormatter();
        }
        return self::$standardFormatter;
    }

    /**
     * @return ItemFormatterInterface
     */
    protected static function getDebugFormatter(): ItemFormatterInterface
    {
        if (null === self::$debugFormatter) {
            $typeFormatter = new TypeFormatter(
                null,
                'bool',
                'float',
                'int',
                'null',
                postfix: ':'
            );
            self::$debugFormatter = new ItemFormatter(true, typeFormatter: $typeFormatter);
        }
        return self::$debugFormatter;
    }

    /**
     * @return ArrayFormatterInterface
     */
    protected static function getListFormatter(): ArrayFormatterInterface
    {
        if (null === self::$listFormatter) {
            $itemFormatter = new ItemFormatter(stringFormatter: new StringFormatter('', ''));
            self::$listFormatter = new ExtendedArrayFormatter(
                itemFormatter: $itemFormatter,
                itemSeparator: '|',
                prefix: '',
                postfix: ''
            );
        }
        return self::$listFormatter;
    }

    /**
     * @inheritDoc
     */
    public static function toClassName(object|string $value): string
    {
        return self::getStandardFormatter()->getObjectFormatter()->toClassName($value);
    }

    /**
     * @inheritDoc
     */
    public static function toDebugString(mixed $value, int $maxLength = 0): string
    {
        if (0 === $maxLength) {
            return self::getDebugFormatter()->toString($value);
        }

        $string = self::getDebugFormatter()->toString($value);
        return (new LengthFormatter($maxLength))->toString($string);
    }

    /**
     * @inheritDoc
     */
    public static function toMessage(string $message, ?array $values = null): string
    {
        return self::getDebugFormatter()->toMessage($message, $values);
    }

    /**
     * @inheritDoc
     */
    public static function toShortClassName(object|string $value): string
    {
        return self::getStandardFormatter()->getObjectFormatter()->toShortClassName($value);
    }

    /**
     * @inheritDoc
     */
    public static function toString(mixed $value, int $maxLength = 0): string
    {
        if (0 === $maxLength) {
            return self::getStandardFormatter()->toString($value);
        }

        $string = self::getStandardFormatter()->toString($value);
        return (new LengthFormatter($maxLength))->toString($string);
    }

    /**
     * @inheritDoc
     */
    public static function toType(mixed $value): string
    {
        return self::getStandardFormatter()->getTypeFormatter()->toString($value);
    }

    /**
     * @inheritDoc
     */
    public static function toValueList(array $values, int $maxLength = 0): string
    {
        if (0 === $maxLength) {
            return self::getListFormatter()->toString($values);
        }

        $string = self::getListFormatter()->toString($values);
        return (new LengthFormatter($maxLength))->toString($string);
    }
}
