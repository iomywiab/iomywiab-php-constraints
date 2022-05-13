<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: IsArraySameTypeItemsOrNullTest.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 21:54:13
 * Version......: v2
 */

/** @noinspection RedundantSuppression */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints_tests\simple;

use iomywiab\iomywiab_php_constraints\constraints\simple\IsArraySameTypeItems;
use iomywiab\iomywiab_php_constraints_testtools\ConstraintTestCase;
use iomywiab\iomywiab_php_constraints_testtools\StandardTestValues;
use iomywiab\iomywiab_php_constraints_testtools\TestValues;

/**
 */
class IsArraySameTypeItemsOrNullTest extends ConstraintTestCase
{
    /**
     * @param mixed       $name
     * @param array  $data
     * @param mixed $dataName
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function __construct(
        mixed $name = null,
        array $data = [],
        mixed $dataName = ''
    ) {
        $arrayEqual = [];
        $arrayUnequal = [];
        $values = [null, true, false, 1, 2, 3.4, 5.6, 'a', 'b', new \stdClass(), new \Exception()];
        foreach ($values as $value1) {
            foreach ($values as $value2) {
                $type1 = \gettype($value1);
                $type2 = \gettype($value2);
                if ($type1 !== $type2) {
                    $arrayUnequal[] = [$value1, $value2];
                    continue;
                }
//                if ('object' === $type1) {
//                    $class1 = \get_class($value1);
//                    $class2 = \get_class($value2);
//                    if ($class1 !== $class2) {
//                        $arrayUnequal[] = [$value1, $value2];
//                        continue;
//                    }
//                }
                $arrayEqual[] = [$value1, $value2];
            }
        }

        $validSamples = StandardTestValues::makeUnion($arrayEqual, StandardTestValues::get(StandardTestValues::ARRAYS));
        $testValues = new TestValues($validSamples, $arrayUnequal);

        parent::__construct(new IsArraySameTypeItems(), $testValues, false, $name, $data, $dataName);
    }
}
