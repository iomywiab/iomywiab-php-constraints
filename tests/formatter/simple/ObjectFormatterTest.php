<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ObjectFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 20:21:12
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotNull;
use iomywiab\iomywiab_php_constraints\formatter\simple\ObjectFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\ObjectFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class ObjectFormatterTest extends TestCase
{
    /**
     * @param string|null $valuePrefix
     * @param string|null $valuePostfix
     * @param string|null $prefix
     * @param string|null $postfix
     * @param object      $value
     * @param string      $expected
     * @return void
     * @dataProvider valuesProvider
     * @noinspection PhpTooManyParametersInspection
     */
    public function testValues(
        ?string $valuePrefix,
        ?string $valuePostfix,
        ?string $prefix,
        ?string $postfix,
        object $value,
        string $expected
    ): void {
        $formatter = new ObjectFormatter($valuePrefix, $valuePostfix, $prefix, $postfix);
        self::assertSame($expected, $formatter->toString($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function valuesProvider(): array
    {
        return [
            [null, null, null, null, new \stdClass(), 'stdClass'],
            [null, null, null, null, new IsNotNull(), 'IsNotNull'],
            [null, null, null, null, new \DateTime('1970-09-02'), 'DateTime:[1970-09-02T00:00:00+00:00]'],

            ['(', ')', '--==', '==--', new \stdClass(), '--==stdClass==--'],
            ['(', ')', '--==', '==--', new IsNotNull(), '--==IsNotNull==--'],
            ['(', ')', '--==', '==--', new \DateTime('1970-09-02'), '--==DateTime(1970-09-02T00:00:00+00:00)==--'],
        ];
    }

    /**
     * @param ObjectFormatterInterface $formatter
     * @param string                   $valuePrefix
     * @param string                   $valuePostfix
     * @param string                   $prefix
     * @param string                   $postfix
     * @return void
     */
    protected function checkFormatter(
        ObjectFormatterInterface $formatter,
        string $valuePrefix,
        string $valuePostfix,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($valuePrefix, $formatter->getValuePrefix());
        self::assertSame($valuePostfix, $formatter->getValuePostfix());
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testValuePrefix(): void
    {
        $formatter1 = new ObjectFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withValuePrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'x', 'b', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testValuePostfix(): void
    {
        $formatter1 = new ObjectFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withValuePostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'a', 'x', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $formatter1 = new ObjectFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'x');
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $formatter1 = new ObjectFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'a', 'b', 'x', 'd');
    }
}
