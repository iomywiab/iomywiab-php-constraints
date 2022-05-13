<?php

/*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ItemFormatterInterface.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\complex;

use iomywiab\iomywiab_php_constraints\formatter\FormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\BooleanFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\FloatFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\IntegerFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\StringFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\LengthFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\NullFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\ObjectFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\ResourceFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\TypeFormatterInterface;

/**
 * @psalm-immutable
 */
interface ItemFormatterInterface extends FormatterInterface
{
    /**
     * @param mixed $value
     * @return string
     */
    public function toString(mixed $value): string;

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function toType(mixed $value): string;

    /**
     * @param string|null $string
     * @return string
     */
    public function toReducedString(?string $string): string;

    /**
     * @param string     $message
     * @param array|null $values
     * @return string
     */
    public function toMessage(string $message, ?array $values = null): string;

    /**
     * @return bool
     */
    public function isUseTypePrefix(): bool;

    /**
     * @return ArrayFormatterInterface
     */
    public function getArrayFormatter(): ArrayFormatterInterface;

    /**
     * @return BooleanFormatterInterface
     */
    public function getBooleanFormatter(): BooleanFormatterInterface;

    /**
     * @return FloatFormatterInterface
     */
    public function getFloatFormatter(): FloatFormatterInterface;

    /**
     * @return IntegerFormatterInterface
     */
    public function getIntegerFormatter(): IntegerFormatterInterface;

    /**
     * @return LengthFormatterInterface
     */
    public function getLengthFormatter(): LengthFormatterInterface;

    /**
     * @return MessageFormatterInterface
     */
    public function getMessageFormatter(): MessageFormatterInterface;

    /**
     * @return NullFormatterInterface
     */
    public function getNullFormatter(): NullFormatterInterface;

    /**
     * @return ObjectFormatterInterface
     */
    public function getObjectFormatter(): ObjectFormatterInterface;

    /**
     * @return ResourceFormatterInterface
     */
    public function getResourceFormatter(): ResourceFormatterInterface;

    /**
     * @return StringFormatterInterface
     */
    public function getStringFormatter(): StringFormatterInterface;

    /**
     * @return TypeFormatterInterface
     */
    public function getTypeFormatter(): TypeFormatterInterface;

    /**
     * @param bool $useTypePrefix
     * @return static
     */
    public function withUseTypePrefix(bool $useTypePrefix): static;

    /**
     * @param FormatterInterface $formatter
     * @return static
     */
    public function withFormatter(FormatterInterface $formatter): static;

    /**
     * @param ArrayFormatterInterface $arrayFormatter
     * @return static
     */
    public function withArrayFormatter(ArrayFormatterInterface $arrayFormatter): static;

    /**
     * @param BooleanFormatterInterface $booleanFormatter
     * @return static
     */
    public function withBooleanFormatter(BooleanFormatterInterface $booleanFormatter): static;

    /**
     * @param FloatFormatterInterface $floatFormatter
     * @return static
     */
    public function withFloatFormatter(FloatFormatterInterface $floatFormatter): static;

    /**
     * @param IntegerFormatterInterface $integerFormatter
     * @return static
     */
    public function withIntegerFormatter(IntegerFormatterInterface $integerFormatter): static;

    /**
     * @param LengthFormatterInterface $lengthFormatter
     * @return static
     */
    public function withLengthFormatter(LengthFormatterInterface $lengthFormatter): static;

    /**
     * @param MessageFormatterInterface $messageFormatter
     * @return static
     */
    public function withMessageFormatter(MessageFormatterInterface $messageFormatter): static;

    /**
     * @param NullFormatterInterface $nullFormatter
     * @return static
     */
    public function withNullFormatter(NullFormatterInterface $nullFormatter): static;

    /**
     * @param ObjectFormatterInterface $objectFormatter
     * @return static
     */
    public function withObjectFormatter(ObjectFormatterInterface $objectFormatter): static;

    /**
     * @param ResourceFormatterInterface $resourceFormatter
     * @return static
     */
    public function withResourceFormatter(ResourceFormatterInterface $resourceFormatter): static;

    /**
     * @param StringFormatterInterface $stringFormatter
     * @return static
     */
    public function withStringFormatter(StringFormatterInterface $stringFormatter): static;

    /**
     * @param TypeFormatterInterface $typeFormatter
     * @return static
     */
    public function withTypeFormatter(TypeFormatterInterface $typeFormatter): static;
}
