<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: MessageFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 20:21:02
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\complex;

use iomywiab\iomywiab_php_constraints\formatter\complex\ArrayFormatter;
use iomywiab\iomywiab_php_constraints\formatter\complex\ArrayFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\complex\MessageFormatter;
use iomywiab\iomywiab_php_constraints\formatter\complex\MessageFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class MessageFormatterTest extends TestCase
{
    /**
     * @param string     $message
     * @param string     $expected
     * @param array|null $values
     * @return void
     * @dataProvider valuesProvider
     */
    public function testDefaults(
        string $message,
        ?array $values,
        string $expected
    ): void {
        $formatter = new MessageFormatter();
        self::assertSame($expected, $formatter->toString($message, $values));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function valuesProvider(): array
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
     * @param MessageFormatterInterface $formatter
     * @param ArrayFormatterInterface   $arrayFormatter
     * @param string                    $prefix
     * @param string                    $postfix
     * @return void
     */
    protected function checkFormatter(
        MessageFormatterInterface $formatter,
        ArrayFormatterInterface $arrayFormatter,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($arrayFormatter, $formatter->getArrayFormatter());
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testArrayFormatter(): void
    {
        $arrayFormatter1 = new ArrayFormatter();
        $arrayFormatter2 = new ArrayFormatter();
        $formatter1 = new MessageFormatter($arrayFormatter1, 'a', 'b');
        $formatter2 = $formatter1->withArrayFormatter($arrayFormatter2);
        $this->checkFormatter($formatter1, $arrayFormatter1, 'a', 'b');
        $this->checkFormatter($formatter2, $arrayFormatter2, 'a', 'b');
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $arrayFormatter = new ArrayFormatter();
        $formatter1 = new MessageFormatter($arrayFormatter, 'a', 'b');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, $arrayFormatter, 'a', 'b');
        $this->checkFormatter($formatter2, $arrayFormatter, 'x', 'b');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $arrayFormatter = new ArrayFormatter();
        $formatter1 = new MessageFormatter($arrayFormatter, 'a', 'b');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, $arrayFormatter, 'a', 'b');
        $this->checkFormatter($formatter2, $arrayFormatter, 'a', 'x');
    }
}
