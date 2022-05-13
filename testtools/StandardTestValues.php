<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: StandardTestValues.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 21:35:45
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_testtools;

/**
 */
class StandardTestValues
{
    public const ARRAYS = 1;
    public const BOOLEANS = self::ARRAYS << 1;
    public const FLOATS = self::BOOLEANS << 1;
    public const INTEGERS = self::FLOATS << 1;
    public const NULLS = self::INTEGERS << 1;
    public const OBJECTS = self::NULLS << 1;
    public const STRINGS = self::OBJECTS << 1;

    public const SCALARS = self::BOOLEANS | self::FLOATS | self::INTEGERS | self::STRINGS;
    public const ALL = self::SCALARS | self::ARRAYS | self::NULLS | self::OBJECTS;

    protected const BOOLEAN_VALUES = [
        true,
        false
    ];
    protected const INTEGER_VALUES = [
        PHP_INT_MIN,
        -1,
        0,
        1,
        PHP_INT_MAX,
    ];
    protected const FLOAT_VALUES = [
        -PHP_FLOAT_MAX,
        -2.3,
        -1.0,
        0.0,
        1.0,
        2.3,
        123456789.123456789,
        PHP_FLOAT_MAX,
    ];
    protected const STRING_VALUES = [
        '',
        'null',
        'true',
        'false',
        '-9223372036854775808', // PHP_INT_MIN
        '-1',
        '0',
        '1',
        '9223372036854775807', // PHP_INT_NAX
        '-1.7976931348623e+308', // -PHP_FLOAT_MAX
        '-2.3',
        '-1.0',
        '0.0',
        '1.0',
        '2.3',
        '123456789.123456789',
        '1.7976931348623e+308', // PHP_FLOAT_MAX
        'abc',
        'This ia a long string with some repetitions. This ia a long string with some repetitions. '
    ];

    /**
     * @var array<int,array>
     */
    private static array $cache = [];

    private static ?\Exception $exception = null;
    private static ?\stdClass $stdClass = null;

    /**
     * @param int $selection
     * @return array<int,mixed>
     */
    public static function get(int $selection = self::ALL): array
    {
        if (self::ALL < $selection) {
            throw new \InvalidArgumentException('Invalid selection: [' . $selection . ']');
        }

        $found = self::$cache[$selection] ?? null;
        if (null !== $found) {
            return $found;
        }

        $values = self::create($selection);
        self::$cache[$selection] = $values;
        return $values;
    }

    /**
     * @param int $selection
     * @return array<int,mixed>
     */
    protected static function create(int $selection = self::ALL): array
    {
        $values = [];

        if ($selection & self::BOOLEANS) {
            $values = self::makeUnion($values, self::BOOLEAN_VALUES);
        }

        if ($selection & self::FLOATS) {
            $values = self::makeUnion($values, self::FLOAT_VALUES);
        }

        if ($selection & self::INTEGERS) {
            $values = self::makeUnion($values, self::INTEGER_VALUES);
        }

        if ($selection & self::NULLS) {
            $values[] = null;
        }

        if ($selection & self::OBJECTS) {
            $values = self::makeUnion($values, [self::getException(), self::getStdClass()]);
        }

        if ($selection & self::STRINGS) {
            $values = self::makeUnion($values, self::STRING_VALUES);
        }

        if ($selection & self::ARRAYS) {
            $types = [self::BOOLEANS, self::FLOATS, self::INTEGERS, self::NULLS, self::OBJECTS, self::STRINGS];
            foreach ($types as $type) {
                $samples = self::get($type);
                foreach ($samples as $sample) {
                    $values [] = [$sample];
                }
            }
        }

        return $values;
    }

    /**
     * @return \Exception
     */
    public static function getException(): \Exception
    {
        if (null === self::$exception) {
            self::$exception = new \Exception();
        }
        return self::$exception;
    }

    /**
     * @return \stdClass
     */
    public static function getStdClass(): \stdClass
    {
        if (null === self::$stdClass) {
            self::$stdClass = new \stdClass();
        }
        return self::$stdClass;
    }

    /**
     * unite all values, ignore key and reindex all
     * @param array $source1
     * @param array $source2
     * @return array<int,mixed>
     */
    public static function makeUnion(array $source1, array $source2): array
    {
        $array = [];
        foreach ($source1 as $item) {
            $array[] = $item;
        }
        foreach ($source2 as $item) {
            $array[] = $item;
        }
        return $array;
    }
}
