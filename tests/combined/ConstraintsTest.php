<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ConstraintsTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:04:25
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\combined;

use iomywiab\iomywiab_php_constraints\constraints\combined\Constraints;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsGreaterOrEqual;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsLessOrEqual;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 */
class ConstraintsTest extends ConstraintTestCase
{
    /**
     * @param mixed $name
     * @param array $data
     * @param mixed $dataName
     */
    public function __construct(
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        $constraint = (new Constraints())
            ->setNotNull()
            ->setNotEmpty()
            ->setType(IsType::STRING)
            ->setMaxLength(5)
            ->setMinLength(5)
            ->setRegEx('/^[A-Za-z]*$/')
            ->setInArray(['small', 'LARGE']);
        $validSamples = ['small', 'LARGE'];
        $invalidSamples = ['LARGER', 'tiny'];

        $testValues = new TestValues($validSamples, $invalidSamples);
        parent::__construct($constraint, $testValues, false, $name, $data, $dataName);
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testFurther(): void
    {
        $constraint = (new Constraints())
            ->setMinimum(2)
            ->setMaximum(4);

        $this->checkConstraint(
            $constraint,
            [2, 3, 4, 2.3, '2.3'],
            [0, 1, 5, 6]
        );

        $constraint = (new Constraints())
            ->add(new IsGreaterOrEqual(2))
            ->add(new IsLessOrEqual(4));

        $this->checkConstraint(
            $constraint,
            [2, 3, 4, 2.3, '2.3'],
            [0, 1, 5, 6]
        );

        $constraint = (new Constraints())
            ->add([new IsGreaterOrEqual(2), new IsLessOrEqual(4)]);

        $this->checkConstraint(
            $constraint,
            [2, 3, 4, 2.3, '2.3'],
            [0, 1, 5, 6]
        );

        $constraint = (new Constraints())
            ->add(new IsType('integer'))
            ->add([Constraints::IDX_MIN => new IsGreaterOrEqual(2), Constraints::IDX_MAX => new IsLessOrEqual(4)]);

        $this->checkConstraint(
            $constraint,
            [2, 3, 4],
            [0, 1, 5, 6]
        );
    }
}
