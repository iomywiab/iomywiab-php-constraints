<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ConstraintTestCase.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/ConstraintTestCase.php
 * Class name...: ConstraintTestCase.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 17:58:05
 */

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ConstraintTestCase.php
 * File path....: C:/_GitLocal/iomywiab-php-constraints/tests/ConstraintTestCase.php
 * Class name...: ConstraintTestCase.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-06-23 15:55:43
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests;

use Exception;
use iomywiab\iomywiab_php_constraints\Format;
use iomywiab\iomywiab_php_constraints\interfaces\ConstraintInterface;
use PHPUnit\Framework\TestCase;


/**
 * Class NumericTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
abstract class ConstraintTestCase extends TestCase
{
    /**
     * @var Exception
     */
    protected static $testException;

    /**
     * ConstraintTestCase constructor.
     * @param null   $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        if (empty(self::$testException)) {
            self::$testException = new Exception();
        }
    }

    /**
     * @param ConstraintInterface $constraint
     * @param array               $expectedOk
     * @param array               $expectedBad
     * @param bool                $showProgress
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function checkConstraint(
        ConstraintInterface $constraint,
        array $expectedOk,
        array $expectedBad,
        bool $showProgress = false
    ): void {
        $errors = [];

        // serialization
        $this->show($showProgress, 'Testing serialization...');
        self::assertEquals($constraint, unserialize(serialize($constraint)));

        $values = [
            /* null: */
            null,
            /* booleans */
            true,
            false,
            /* integers */
            -1,
            0,
            1,
            /* floats */
            -1.0,
            0.0,
            1.0,
            /* strings */
            '',
            'abc',
            'true',
            'false',
            '-1',
            '0',
            '1',
            /* arrays */
            [],
            [null],
            [true],
            [false],
            [-1],
            [0],
            [1],
            [-1.0],
            [0.0],
            [1.0],
            [''],
            ['abc'],
            /* objects */
            self::$testException
        ];
        $prefix = 'Testing ' . Format::toShortClassName($constraint) . '->isValidValue(';
        $postfix = ')...';
        foreach ($values as $value) {
            $this->show($showProgress, $prefix . Format::toDescription($value) . $postfix);
            self::assertEquals(in_array($value, $expectedOk, true), $constraint->isValidValue($value, null, $errors));
        }

        // check all expected ok - there might be some additional checks not covered above
        if (!empty($expectedOk)) {
            foreach ($expectedOk as $item) {
                $this->show($showProgress, $prefix . Format::toDescription($item) . $postfix);
                self::assertTrue($constraint->isValidValue($item, null, $errors));
                $constraint->assertValue($item);
            }
        }

        // check all expected bad
        if (!empty($expectedBad)) {
            foreach ($expectedBad as $item) {
                $this->show($showProgress, $prefix . Format::toDescription($item) . $postfix);
                self::assertFalse($constraint->isValidValue($item, null, $errors));
            }
        }

        var_dump($errors);
    }

    /**
     * @param bool   $enabled
     * @param string $message
     */
    private function show(bool $enabled, string $message): void
    {
        if ($enabled) {
            fwrite(STDOUT, $message);
            fwrite(STDOUT, "\n");
            fflush(STDOUT);
        }
    }

}