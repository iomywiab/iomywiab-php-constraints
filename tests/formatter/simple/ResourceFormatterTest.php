<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ResourceFormatterTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 08:43:58
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\formatter\simple;

use iomywiab\iomywiab_php_constraints\formatter\simple\ResourceFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\ResourceFormatterInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class ResourceFormatterTest extends TestCase
{
    /**
     * @param string|null $idPrefix
     * @param string|null $idPostfix
     * @param string|null $prefix
     * @param string|null $postfix
     * @param resource      $value
     * @param string      $expected
     * @return void
     * @dataProvider valuesProvider
     * @noinspection PhpTooManyParametersInspection
     */
    public function testValues(
        ?string $idPrefix,
        ?string $idPostfix,
        ?string $prefix,
        ?string $postfix,
        mixed $value,
        string $expected
    ): void {
        $formatter = new ResourceFormatter($idPrefix, $idPostfix, $prefix, $postfix);
        self::assertSame($expected, $formatter->toString($value));
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function valuesProvider(): array
    {
        $name = __DIR__ . '/../../../logs/unit-test.txt';
        $fileClosed = fopen($name, 'rb');
        fclose($fileClosed);
        $fileOpened = fopen($name, 'rb');
        $idSTDOUT = \get_resource_id(STDOUT);
        $idFileOpened = \get_resource_id($fileOpened);
        $idFileClosed = \get_resource_id($fileClosed);

        return [
            [null, null, null, null, STDOUT, 'stream(id=2)'],
            [null, null, null, null, $fileOpened, 'stream(id=' . $idFileOpened . ')'],
            [null, null, null, null, $fileClosed, 'Unknown(id=' . $idFileClosed . ')'],

            ['[[', ']]', '--==', '==--', STDOUT, '--==stream[[' . $idSTDOUT . ']]==--'],
            ['[[', ']]', '--==', '==--', $fileOpened, '--==stream[[' . $idFileOpened . ']]==--'],
            ['[[', ']]', '--==', '==--', $fileClosed, '--==Unknown[[' . $idFileClosed . ']]==--'],
        ];
    }

    /**
     * @param ResourceFormatterInterface $formatter
     * @param string                     $idPrefix
     * @param string                     $idPostfix
     * @param string                     $prefix
     * @param string                     $postfix
     * @return void
     */
    protected function checkFormatter(
        ResourceFormatterInterface $formatter,
        string $idPrefix,
        string $idPostfix,
        string $prefix,
        string $postfix
    ): void {
        self::assertSame($idPrefix, $formatter->getIdPrefix());
        self::assertSame($idPostfix, $formatter->getIdPostfix());
        self::assertSame($prefix, $formatter->getPrefix());
        self::assertSame($postfix, $formatter->getPostfix());
    }

    /**
     * @return void
     */
    public function testIdPrefix(): void
    {
        $formatter1 = new ResourceFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withIdPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'x', 'b', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testIdPostfix(): void
    {
        $formatter1 = new ResourceFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withIdPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'a', 'x', 'c', 'd');
    }

    /**
     * @return void
     */
    public function testPostfix(): void
    {
        $formatter1 = new ResourceFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withPostfix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'a', 'b', 'c', 'x');
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $formatter1 = new ResourceFormatter('a', 'b', 'c', 'd');
        $formatter2 = $formatter1->withPrefix('x');
        $this->checkFormatter($formatter1, 'a', 'b', 'c', 'd');
        $this->checkFormatter($formatter2, 'a', 'b', 'x', 'd');
    }
}
