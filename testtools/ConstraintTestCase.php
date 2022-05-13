<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ConstraintTestCase.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 21:36:47
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_testtools;

use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints\formatter\complex\Format;
use iomywiab\iomywiab_php_constraints\interfaces\ConstraintInterface;
use PHPUnit\Framework\TestCase;

/**
 */
abstract class ConstraintTestCase extends TestCase
{
    /**
     * ConstraintTestCase constructor.
     * @param ConstraintInterface $constraint
     * @param TestValues          $testValues
     * @param bool                $showProgress
     * @param mixed               $name
     * @param array               $data
     * @param mixed               $dataName
     */
    public function __construct(
        protected ConstraintInterface $constraint,
        protected TestValues $testValues,
        protected readonly bool $showProgress = false,
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        parent::__construct($name, $data, $dataName);
    }

    /**
     */
    public function testSerialization(): void
    {
        $this->writeln('Testing serialization...');
        self::assertEquals($this->constraint, unserialize(serialize($this->constraint), ['allowed_classes' => true]));
    }

    /**
     * @param mixed $value
     * @param bool  $isExpectedOk
     * @return void
     * @dataProvider valueProvider
     * @throws \ReflectionException
     * @noinspection MessDetectorValidationInspection
     */
    public function testIsValidValue(mixed $value, bool $isExpectedOk): void
    {
        if (221 === $this->dataName()) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $breakpoint = true;
        }

        $errors = [];

        $this->writeTesting($value);
        $isValid = $this->constraint->isValidValue($value, null, $errors);
        $message = 'Error testing value=' . Format::toDebugString($value)
            . ' (was expected ' . ($isExpectedOk ? 'ok' : 'bad') . ')';
        self::assertSame($isExpectedOk, $isValid, $message);

//        if (!empty($errors)) {
//            /** @noinspection ForgottenDebugOutputInspection */
//            var_dump($errors);
//        }
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function valueProvider(): array
    {
        $result = [];

        $allValues = StandardTestValues::get(StandardTestValues::ALL);
        foreach ($allValues as $value) {
            $isValid = $this->testValues->isValidSample($value);
            $result[] = [$value, $isValid];
        }

        foreach ($this->testValues->validSamples as $value) {
            $result[] = [$value, true];
        }

        foreach ($this->testValues->invalidSamples as $value) {
            $result[] = [$value, false];
        }

        return $result;
    }

    /**
     * @param ConstraintInterface $constraint
     * @param array<int,mixed>    $validSamples
     * @param array<int,mixed>    $invalidSamples
     * @return void
     */
    protected function checkConstraint(
        ConstraintInterface $constraint,
        array $validSamples,
        array $invalidSamples
    ): void {
        $oldTestValues = $this->testValues;
        $oldConstraint = $this->constraint;

        try {
            $this->constraint = $constraint;
            $this->testValues = new TestValues($validSamples, $invalidSamples);
            $values = $this->valueProvider();
            foreach ($values as $value) {
                \call_user_func_array([self::class,'testIsValidValue'], $value);
            }
        } finally {
            $this->constraint = $oldConstraint;
            $this->testValues = $oldTestValues;
        }
    }

    /**
     * @param mixed $value
     * @param bool  $assertionOk
     * @return void
     * @dataProvider valueProvider
     * @throws \ReflectionException
     */
    public function testAssertValue(mixed $value, bool $assertionOk): void
    {
        self::assertTrue(true);
        $this->writeTesting($value);
        try {
            $this->constraint->assertValue($value);
            if (!$assertionOk) {
                $message = 'Value=' . Format::toDebugString($value)
                    . ' was expected to violate constraint, but did not';
                self::fail($message);
            }
        } catch (ConstraintViolationException $cause) {
            if ($assertionOk) {
                $message = 'Value=' . Format::toDebugString($value)
                    . ' was not expected to violate constraint, but threw exception ('
                    . $cause->getMessage() . ')';
                self::fail($message);
            }
        }
    }

    /**
     * @param string $message
     */
    private function writeln(string $message): void
    {
        if ($this->showProgress) {
            $message .= PHP_EOL;
            fwrite(STDOUT, $message);
            fflush(STDOUT);
        }
    }

    /**
     * @param mixed $value
     * @throws \ReflectionException
     */
    private function writeTesting(mixed $value): void
    {
        if ($this->showProgress) {
            $message = 'Testing '
                . Format::toShortClassName($this->constraint) . '->isValidValue('
                . Format::toDebugString($value) . ')...';
            $this->writeln($message);
        }
    }
}
