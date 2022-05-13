<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: AbstractNumberFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:42
 * Version......: v2
 */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\scalar;

use iomywiab\iomywiab_php_constraints\formatter\AbstractFormatter;

/**
 * @psalm-immutable
 */
abstract class AbstractNumberFormatter extends AbstractFormatter implements NumberFormatterInterface
{
    /**
     * @param string $plusPrefix
     * @param string $plusPostfix
     * @param string $minusPrefix
     * @param string $minusPostfix
     * @param string $prefix
     * @param string $postfix
     */
    public function __construct(
        public readonly string $plusPrefix,
        public readonly string $plusPostfix,
        public readonly string $minusPrefix,
        public readonly string $minusPostfix,
        string $prefix,
        string $postfix
    ) {
        parent::__construct($prefix, $postfix);
        \assert($this->plusPrefix !== $this->minusPrefix || ('' === $this->plusPrefix && '' === $this->minusPrefix));
        \assert(
            $this->plusPostfix !== $this->minusPostfix || ('' === $this->plusPostfix && '' === $this->minusPostfix)
        );
    }

    /**
     * @inheritDoc
     */
    public function getPlusPrefix(): string
    {
        return $this->plusPrefix;
    }

    /**
     * @inheritDoc
     */
    public function getPlusPostfix(): string
    {
        return $this->plusPostfix;
    }

    /**
     * @inheritDoc
     */
    public function getMinusPrefix(): string
    {
        return $this->minusPrefix;
    }

    /**
     * @inheritDoc
     */
    public function getMinusPostfix(): string
    {
        return $this->minusPostfix;
    }
}
