<?php
/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2021 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ConstraintsTest.php
 * Class name...: ConstraintsTest.php
 * Project name.: iomywiab-php-constraints
 * Module name..: iomywiab-php-constraints
 * Last modified: 2021-10-20 18:30:33
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\combined;

use Exception;
use iomywiab\iomywiab_php_constraints\constraints\combined\Constraints;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsGreaterOrEqual;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsLessOrEqual;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsValidType;
use iomywiab\iomywiab_php_constraints\exceptions\ConstraintViolationException;
use iomywiab\iomywiab_php_constraints_tests\ConstraintTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class ConstraintsTest
 * @package iomywiab\iomywiab_php_constraints_tests
 */
class ConstraintsTest extends ConstraintTestCase
{

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ConstraintViolationException
     */
    public function testIsValid(): void
    {
        $constraint = (new Constraints())
            ->setNotNull()
            ->setNotEmpty()
            ->setType(IsType::STRING)
            ->setMaxLength(5)
            ->setMinLength(5)
            ->setRegEx('/^[A-Za-z]*$/')
            ->setInArray(['small', 'LARGE']);

        $this->checkConstraint(
            $constraint,
            ['small', 'LARGE'],
            ['LARGER', 'tiny']
        );

        $constraint = (new Constraints())
            ->setMinimum(2)
            ->setMaximum(4);

        $this->checkConstraint(
            $constraint,
            [2, 3, 4],
            [0, 1, 5, 6]
        );

        $constraint = (new Constraints())
            ->add(new IsGreaterOrEqual(2))
            ->add(new IsLessOrEqual(4));

        $this->checkConstraint(
            $constraint,
            [2, 3, 4],
            [0, 1, 5, 6]
        );

        $constraint = (new Constraints())
            ->add([new IsGreaterOrEqual(2), new IsLessOrEqual(4)]);

        $this->checkConstraint(
            $constraint,
            [2, 3, 4],
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

    /**
     * @throws ConstraintViolationException
     * @throws Exception
     */
    public function testAssert(): void
    {
        self::expectException(ConstraintViolationException::class);
        $constraint = (new Constraints())
            ->setNotNull()
            ->setNotEmpty()
            ->setType(IsValidType::STRING)
            ->setMaxLength(5)
            ->setMinLength(5)
            ->setRegEx('/^[A-Za-z]*$/')
            ->setInArray(['small', 'LARGE']);
        try {
            $constraint->assertValue('small');
            $constraint->assertValue('LARGE');
        } catch (Exception $cause) {
            throw new Exception('Unexpected exception', 0, $cause);
        }
        $constraint->assertValue('LARGER');
    }
}