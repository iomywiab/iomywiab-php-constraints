<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ItemFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 17:55:26
 * Version......: v2
 */

/** @noinspection SpellCheckingInspection */

/** @noinspection MessDetectorValidationInspection */

/** @noinspection EfferentObjectCouplingInspection */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\complex;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotNull;
use iomywiab\iomywiab_php_constraints\formatter\complex\ArrayFormatter;
use iomywiab\iomywiab_php_constraints\formatter\complex\ArrayFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\complex\ItemFormatter;
use iomywiab\iomywiab_php_constraints\formatter\complex\ItemFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\complex\MessageFormatter;
use iomywiab\iomywiab_php_constraints\formatter\complex\MessageFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\BooleanFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\BooleanFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\FloatFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\FloatFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\IntegerFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\IntegerFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\StringFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\StringFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\LengthFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\LengthFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\NullFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\NullFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\ObjectFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\ObjectFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\ResourceFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\ResourceFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\TypeFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\TypeFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class ItemFormatterTest extends TestCase
{
    /**
     * @param mixed  $value
     * @param string $expected
     * @return void
     * @dataProvider toStringProvider
     */
    public function testToString(mixed $value, string $expected): void
    {
        if (23 === $this->dataName()) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $breakpoint = true;
        }
        $formatter = new ItemFormatter();
        self::assertSame($expected, $formatter->toString($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function toStringProvider(): array
    {
        $name = __DIR__ . '/../../../logs/unit-test.txt';
        $fileClosed = fopen($name, 'rb');
        fclose($fileClosed);
        $fileOpened = fopen($name, 'rb');
        $idSTDOUT = \get_resource_id(STDOUT);
        $idFileOpened = \get_resource_id($fileOpened);
        $idFileClosed = \get_resource_id($fileClosed);

        return [
            [['a'], '["a"]'],
            [['a', 'b'], '["a","b"]'],
            [['a', 'key' => 'b', 'c'], '["a",key=>"b",1=>"c"]'],
            [['a', 'key' => 'b', 7 => 'c'], '["a",key=>"b",7=>"c"]'],

            [true, BooleanFormatter::DEFAULT_TRUE_STRING],
            [false, BooleanFormatter::DEFAULT_FALSE_STRING],

            [-PHP_FLOAT_MAX, '-1.7976931348623E+308'],
            [-2.3, '-2.3'],
            [-1.0, '-1.0'],
            [0.0, '0.0'],
            [1.0, '1.0'],
            [2.3, '2.3'],
            [PHP_FLOAT_MAX, '1.7976931348623E+308'],

            [PHP_INT_MIN, '-9.2233720368548E+18'],
            [-1, '-1'],
            [0, '0'],
            [1, '1'],
            [PHP_INT_MAX, '9223372036854775807'],

            [new \stdClass(), 'stdClass'],
            [new IsNotNull(), 'IsNotNull'],
            [new \DateTime('1970-09-02'), 'DateTime:[1970-09-02T00:00:00+00:00]'],

            [STDOUT, 'stream(id=' . $idSTDOUT . ')'],
            [$fileOpened, 'stream(id=' . $idFileOpened . ')'],
            [$fileClosed, 'Unknown(id=' . $idFileClosed . ')'],

            ['', '""'],
            ['a', '"a"'],
            ['abc', '"abc"'],
        ];
    }

    /**
     * @param mixed  $value
     * @param string $expected
     * @return void
     * @dataProvider toTypeProvider
     */
    public function testToType(mixed $value, string $expected): void
    {
        $formatter = new ItemFormatter();
        self::assertSame($expected, $formatter->toType($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function toTypeProvider(): array
    {
        $name = __DIR__ . '/../../../logs/unit-test.txt';
        $fileClosed = fopen($name, 'rb');
        fclose($fileClosed);
        return [
            [null, 'NULL'],
            [true, 'boolean'],
            [2.3, 'double'],
            [0, 'integer'],
            ['abc', 'string(3)'],
            [[], 'array(0)'],
            [STDOUT, 'resource'],
            [$fileClosed, 'resource (closed)'],
            [new \stdClass(), 'object'],
            [new IsNotNull(), 'object'],
        ];
    }

    /**
     * @param string $message
     * @param array  $values
     * @param string $expected
     * @return void
     * @dataProvider toMessageProvider
     */
    public function testToMessage(string $message, array $values, string $expected): void
    {
        $formatter = new ItemFormatter();
        self::assertSame($expected, $formatter->toMessage($message, $values));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function toMessageProvider(): array
    {
        return [
            ['test-message1', [], 'test-message1.'],
            ['test-message2.', [], 'test-message2.'],

            ['', ['expected' => 0, 'got' => 1], '[expected=>0,got=>1]'],

            ['test-message3', ['expected' => 0, 'got' => 1], 'test-message3. [expected=>0,got=>1]'],
            ['test-message4.', ['expected' => 0, 'got' => 1], 'test-message4. [expected=>0,got=>1]'],
        ];
    }

    /**
     * @param string $string
     * @param int    $maxLength
     * @param string $expected
     * @return void
     * @dataProvider toReducedStringProvider
     */
    public function testToReducedString(string $string, int $maxLength, string $expected): void
    {
        $formatter = new LengthFormatter($maxLength);
        self::assertSame($expected, $formatter->toString($string));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function toReducedStringProvider(): array
    {
        return [
            ['', 7, ''],
            ['abc456', 7, 'abc456'],
            ['abc4567', 7, 'abc4567'],
            ['abc45678', 7, 'abc4...'],
        ];
    }

    /**
     * @param ItemFormatterInterface     $formatter
     * @param bool                       $useTypePrefix
     * @param ArrayFormatterInterface    $arrayFormatter
     * @param BooleanFormatterInterface  $booleanFormatter
     * @param FloatFormatterInterface    $floatFormatter
     * @param IntegerFormatterInterface  $integerFormatter
     * @param LengthFormatterInterface   $lengthFormatter
     * @param MessageFormatterInterface  $messageFormatter
     * @param NullFormatterInterface     $nullFormatter
     * @param ObjectFormatterInterface   $objectFormatter
     * @param ResourceFormatterInterface $resourceFormatter
     * @param StringFormatterInterface   $stringFormatter
     * @param TypeFormatterInterface     $typeFormatter
     * @param string                     $prefix
     * @param string                     $postfix
     * @return void
     * @noinspection PhpTooManyParametersInspection
     */
    protected function checkFormatter(
        ItemFormatterInterface $formatter,
        bool $useTypePrefix,
        ArrayFormatterInterface $arrayFormatter,
        BooleanFormatterInterface $booleanFormatter,
        FloatFormatterInterface $floatFormatter,
        IntegerFormatterInterface $integerFormatter,
        LengthFormatterInterface $lengthFormatter,
        MessageFormatterInterface $messageFormatter,
        NullFormatterInterface $nullFormatter,
        ObjectFormatterInterface $objectFormatter,
        ResourceFormatterInterface $resourceFormatter,
        StringFormatterInterface $stringFormatter,
        TypeFormatterInterface $typeFormatter,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($useTypePrefix, $formatter->isUseTypePrefix());
        self::assertSame($arrayFormatter, $formatter->getArrayFormatter());
        self::assertSame($booleanFormatter, $formatter->getBooleanFormatter());
        self::assertSame($floatFormatter, $formatter->getFloatFormatter());
        self::assertSame($integerFormatter, $formatter->getIntegerFormatter());
        self::assertSame($lengthFormatter, $formatter->getLengthFormatter());
        self::assertSame($messageFormatter, $formatter->getMessageFormatter());
        self::assertSame($nullFormatter, $formatter->getNullFormatter());
        self::assertSame($objectFormatter, $formatter->getObjectFormatter());
        self::assertSame($resourceFormatter, $formatter->getResourceFormatter());
        self::assertSame($stringFormatter, $formatter->getStringFormatter());
        self::assertSame($typeFormatter, $formatter->getTypeFormatter());
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testArrayFormatter(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $xxxxx = new ArrayFormatter();
        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withArrayFormatter($xxxxx);
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $xxxxx,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testBooleanFormatter(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $xxxxx = new BooleanFormatter();
        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withBooleanFormatter($xxxxx);
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $xxxxx,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testFloatFormatter(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $xxxxx = new FloatFormatter();
        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withFloatFormatter($xxxxx);
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $bool,
            $xxxxx,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testIntegerFormatter(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $xxxxx = new IntegerFormatter();
        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withIntegerFormatter($xxxxx);
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $bool,
            $float,
            $xxxxx,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testLengthFormatter(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $xxxxx = new LengthFormatter();
        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withLengthFormatter($xxxxx);
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $bool,
            $float,
            $int,
            $xxxxx,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testMessageFormatter(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $xxxxx = new MessageFormatter();
        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withMessageFormatter($xxxxx);
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $xxxxx,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testNullFormatter(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $xxxxx = new NullFormatter();
        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withNullFormatter($xxxxx);
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $xxxxx,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testObjectFormatter(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $xxxxx = new ObjectFormatter();
        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withObjectFormatter($xxxxx);
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $xxxxx,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testResourceFormatter(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $xxxxx = new ResourceFormatter();
        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withResourceFormatter($xxxxx);
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $xxxxx,
            $str,
            $type,
            'a',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testStringFormatter(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $xxxxx = new StringFormatter();
        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withStringFormatter($xxxxx);
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $xxxxx,
            $type,
            'a',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testTypeFormatter(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $xxxxx = new TypeFormatter();
        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withTypeFormatter($xxxxx);
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $xxxxx,
            'a',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'x',
            'b'
        );
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $array = new ArrayFormatter();
        $bool = new BooleanFormatter();
        $float = new FloatFormatter();
        $int = new IntegerFormatter();
        $len = new LengthFormatter();
        $msg = new MessageFormatter();
        $null = new NullFormatter();
        $obj = new ObjectFormatter();
        $res = new ResourceFormatter();
        $str = new StringFormatter();
        $type = new TypeFormatter();

        $formatter1 = new ItemFormatter(
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter(
            $formatter1,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'b'
        );
        $this->checkFormatter(
            $formatter2,
            true,
            $array,
            $bool,
            $float,
            $int,
            $len,
            $msg,
            $null,
            $obj,
            $res,
            $str,
            $type,
            'a',
            'x'
        );
    }
}
