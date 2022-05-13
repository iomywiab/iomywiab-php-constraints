<?php /*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ItemFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 17:27:49
 * Version......: v2
 */ /*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ItemFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:04:35
 * Version......: v2
 */ /*
 * This file is part of the iomywiab-php-constraints package.
 *
 * Copyright (c) 2012-2022 Patrick Nehls <iomywiab@premium-postfach.de>, Tornesch, Germany.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * File name....: ItemFormatter.php
 * Project name.: iomywiab-php-constraints
 * Last modified: 2022-05-13 22:56:41
 * Version......: v2
 */ /** @noinspection ALL */

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace iomywiab\iomywiab_php_constraints\formatter\complex;

use iomywiab\iomywiab_php_constraints\formatter\AbstractFormatter;
use iomywiab\iomywiab_php_constraints\formatter\FormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\BooleanFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\BooleanFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\FloatFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\FloatFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\IntegerFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\IntegerFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\scalar\StringFormatter;
use iomywiab\iomywiab_php_constraints\formatter\scalar\StringFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\LengthFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\LengthFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\NullFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\NullFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\ObjectFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\ObjectFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\ResourceFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\ResourceFormatterInterface;
use iomywiab\iomywiab_php_constraints\formatter\simple\TypeFormatter;
use iomywiab\iomywiab_php_constraints\formatter\simple\TypeFormatterInterface;

/**
 * @psalm-immutable
 */
class ItemFormatter extends AbstractFormatter implements ItemFormatterInterface
{
    public const DEFAULT_USE_TYPE_PREFIX = false;
    public const DEFAULT_NOT_AVAILABLE = 'n/a';
    public const DEFAULT_PREFIX = '';
    public const DEFAULT_POSTFIX = '';

    public readonly bool $useTypePrefix;
    public readonly ArrayFormatterInterface $arrayFormatter;
    public readonly BooleanFormatterInterface $booleanFormatter;
    public readonly FloatFormatterInterface $floatFormatter;
    public readonly IntegerFormatterInterface $integerFormatter;
    public readonly LengthFormatterInterface $lengthFormatter;
    public readonly MessageFormatterInterface $messageFormatter;
    public readonly NullFormatterInterface $nullFormatter;
    public readonly ObjectFormatterInterface $objectFormatter;
    public readonly ResourceFormatterInterface $resourceFormatter;
    public readonly StringFormatterInterface $stringFormatter;
    public readonly TypeFormatterInterface $typeFormatter;

    /**
     * @param bool|null                       $useTypePrefix
     * @param ArrayFormatterInterface|null    $arrayFormatter
     * @param BooleanFormatterInterface|null  $booleanFormatter
     * @param FloatFormatterInterface|null    $floatFormatter
     * @param IntegerFormatterInterface|null  $integerFormatter
     * @param LengthFormatterInterface|null   $lengthFormatter
     * @param MessageFormatterInterface|null  $messageFormatter
     * @param NullFormatterInterface|null     $nullFormatter
     * @param ObjectFormatterInterface|null   $objectFormatter
     * @param ResourceFormatterInterface|null $resourceFormatter
     * @param StringFormatterInterface|null   $stringFormatter
     * @param TypeFormatterInterface|null     $typeFormatter
     * @param string|null                     $prefix
     * @param string|null                     $postfix
     */
    public function __construct(
        ?bool $useTypePrefix = null,
        ?ArrayFormatterInterface $arrayFormatter = null,
        ?BooleanFormatterInterface $booleanFormatter = null,
        ?FloatFormatterInterface $floatFormatter = null,
        ?IntegerFormatterInterface $integerFormatter = null,
        ?LengthFormatterInterface $lengthFormatter = null,
        ?MessageFormatterInterface $messageFormatter = null,
        ?NullFormatterInterface $nullFormatter = null,
        ?ObjectFormatterInterface $objectFormatter = null,
        ?ResourceFormatterInterface $resourceFormatter = null,
        ?StringFormatterInterface $stringFormatter = null,
        ?TypeFormatterInterface $typeFormatter = null,
        ?string $prefix = null,
        ?string $postfix = null
    ) {
        parent::__construct($prefix ?? self::DEFAULT_PREFIX, $postfix ?? self::DEFAULT_POSTFIX);
        $this->useTypePrefix = $useTypePrefix ?? self::DEFAULT_USE_TYPE_PREFIX;
        $this->arrayFormatter = $arrayFormatter ?? new ExtendedArrayFormatter($this); // GC problem -> cycle
        $this->booleanFormatter = $booleanFormatter ?? new BooleanFormatter();
        $this->floatFormatter = $floatFormatter ?? new FloatFormatter();
        $this->integerFormatter = $integerFormatter ?? new IntegerFormatter();
        $this->lengthFormatter = $lengthFormatter ?? new LengthFormatter();
        $this->messageFormatter = $messageFormatter ?? new MessageFormatter($this->arrayFormatter); // GC problem->cycle
        $this->nullFormatter = $nullFormatter ?? new NullFormatter();
        $this->objectFormatter = $objectFormatter ?? new ObjectFormatter();
        $this->resourceFormatter = $resourceFormatter ?? new ResourceFormatter();
        $this->stringFormatter = $stringFormatter ?? new StringFormatter();
        $this->typeFormatter = $typeFormatter ?? new TypeFormatter();
    }

    /**
     * @inheritDoc
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function toString(mixed $value): string
    {
        $typePrefix = $this->useTypePrefix && (null !== $value) ? $this->typeFormatter->toString($value) : '';

        $type = \gettype($value);
        $string = match ($type) {
            'array' => $this->arrayFormatter->toString($value),
            'boolean' => $this->booleanFormatter->toString($value),
            'double' => $this->floatFormatter->toString($value),
            'integer' => $this->integerFormatter->toString($value),
            'NULL' => $this->nullFormatter->toString(),
            'object' => $this->objectFormatter->toString($value),
            'resource',
            'resource (closed)' => $this->resourceFormatter->toString($value),
            'string' => $this->stringFormatter->toString($value),
            default => self::DEFAULT_NOT_AVAILABLE,
        };

        return $this->lengthFormatter->toString($this->prefix . $typePrefix . $string . $this->postfix);
    }

    /**
     * @inheritDoc
     */
    public function toType(mixed $value): string
    {
        return $this->typeFormatter->toString($value);
    }

    /**
     * @inheritDoc
     */
    public function toReducedString(?string $string): string
    {
        return null === $string ? '' : $this->lengthFormatter->toString($string);
    }

    /**
     * @inheritDoc
     */
    public function toMessage(string $message, ?array $values = null): string
    {
        return $this->messageFormatter->toString($message, $values);
    }

    /**
     * @inheritDoc
     */
    public function isUseTypePrefix(): bool
    {
        return $this->useTypePrefix;
    }

    /**
     * @inheritDoc
     */
    public function getArrayFormatter(): ArrayFormatterInterface
    {
        return $this->arrayFormatter;
    }

    /**
     * @inheritDoc
     */
    public function getBooleanFormatter(): BooleanFormatterInterface
    {
        return $this->booleanFormatter;
    }

    /**
     * @inheritDoc
     */
    public function getFloatFormatter(): FloatFormatterInterface
    {
        return $this->floatFormatter;
    }

    /**
     * @inheritDoc
     */
    public function getIntegerFormatter(): IntegerFormatterInterface
    {
        return $this->integerFormatter;
    }

    /**
     * @inheritDoc
     */
    public function getLengthFormatter(): LengthFormatterInterface
    {
        return $this->lengthFormatter;
    }

    /**
     * @inheritDoc
     */
    public function getMessageFormatter(): MessageFormatterInterface
    {
        return $this->messageFormatter;
    }

    /**
     * @inheritDoc
     */
    public function getNullFormatter(): NullFormatterInterface
    {
        return $this->nullFormatter;
    }

    /**
     * @inheritDoc
     */
    public function getObjectFormatter(): ObjectFormatterInterface
    {
        return $this->objectFormatter;
    }

    /**
     * @inheritDoc
     */
    public function getResourceFormatter(): ResourceFormatterInterface
    {
        return $this->resourceFormatter;
    }

    /**
     * @inheritDoc
     */
    public function getStringFormatter(): StringFormatterInterface
    {
        return $this->stringFormatter;
    }

    /**
     * @inheritDoc
     */
    public function getTypeFormatter(): TypeFormatterInterface
    {
        return $this->typeFormatter;
    }

    /**
     * @inheritDoc
     * @noinspection MultipleReturnStatementsInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function withFormatter(FormatterInterface $formatter): static
    {
        if ($formatter instanceof ArrayFormatterInterface) {
            return $this->withArrayFormatter($formatter);
        }

        if ($formatter instanceof BooleanFormatterInterface) {
            return $this->withBooleanFormatter($formatter);
        }

        if ($formatter instanceof FloatFormatterInterface) {
            return $this->withFloatFormatter($formatter);
        }

        if ($formatter instanceof IntegerFormatterInterface) {
            return $this->withIntegerFormatter($formatter);
        }

        if ($formatter instanceof LengthFormatterInterface) {
            return $this->withLengthFormatter($formatter);
        }

        if ($formatter instanceof MessageFormatterInterface) {
            return $this->withMessageFormatter($formatter);
        }

        if ($formatter instanceof NullFormatterInterface) {
            return $this->withNullFormatter($formatter);
        }

        if ($formatter instanceof ObjectFormatterInterface) {
            return $this->withObjectFormatter($formatter);
        }

        if ($formatter instanceof ResourceFormatterInterface) {
            return $this->withResourceFormatter($formatter);
        }

        if ($formatter instanceof StringFormatterInterface) {
            return $this->withStringFormatter($formatter);
        }

        if ($formatter instanceof TypeFormatterInterface) {
            return $this->withTypeFormatter($formatter);
        }

        $message = 'Unknown class. expected=[' . ArrayFormatterInterface::class
            . ']. got=[' . \get_class($formatter) . '].';
        throw new \InvalidArgumentException($message);
    }

    /**
     * @inheritDoc
     */
    public function withUseTypePrefix(bool $useTypePrefix): static
    {
        return new self(
            $useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withArrayFormatter(ArrayFormatterInterface $arrayFormatter): static
    {
//        if ($arrayFormatter instanceof ExtendedArrayFormatterInterface) {
//            $arrayFormatter = $arrayFormatter->withItemFormatter($this);
//        }

        return new self(
            $this->useTypePrefix,
            $arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withBooleanFormatter(BooleanFormatterInterface $booleanFormatter): static
    {
        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withFloatFormatter(FloatFormatterInterface $floatFormatter): static
    {
        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withIntegerFormatter(IntegerFormatterInterface $integerFormatter): static
    {
        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withLengthFormatter(LengthFormatterInterface $lengthFormatter): static
    {
        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withMessageFormatter(MessageFormatterInterface $messageFormatter): static
    {
//        $messageFormatter = $messageFormatter->withArrayFormatter($this->arrayFormatter);

        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withNullFormatter(NullFormatterInterface $nullFormatter): static
    {
        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withObjectFormatter(ObjectFormatterInterface $objectFormatter): static
    {
        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withResourceFormatter(ResourceFormatterInterface $resourceFormatter): static
    {
        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withStringFormatter(StringFormatterInterface $stringFormatter): static
    {
        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withTypeFormatter(TypeFormatterInterface $typeFormatter): static
    {
        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $typeFormatter,
            $this->prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withPrefix(string $prefix): static
    {
        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $prefix,
            $this->postfix
        );
    }

    /**
     * @inheritDoc
     */
    public function withPostfix(string $postfix): static
    {
        return new self(
            $this->useTypePrefix,
            $this->arrayFormatter,
            $this->booleanFormatter,
            $this->floatFormatter,
            $this->integerFormatter,
            $this->lengthFormatter,
            $this->messageFormatter,
            $this->nullFormatter,
            $this->objectFormatter,
            $this->resourceFormatter,
            $this->stringFormatter,
            $this->typeFormatter,
            $this->prefix,
            $postfix
        );
    }
}
