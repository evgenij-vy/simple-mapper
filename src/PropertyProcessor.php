<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper;

use DateTimeInterface;
use EvgenijVY\SimpleMapper\Dto\SourcePropertyDataDto;
use EvgenijVY\SimpleMapper\Exception\SourcePropertyNotFoundException;
use EvgenijVY\SimpleMapper\Exception\UnsupportedConversionTypeException;
use EvgenijVY\SimpleMapper\Extractors\ReflectionPropertyExtractor;
use ReflectionObject;
use ReflectionProperty;

class PropertyProcessor
{
    public function process(
        ReflectionProperty $reflectionDestinationProperty,
        ReflectionObject   $sourceReflection,
        object             $sourceObject,
        object             $destinationObject,
    ): void
    {
        try {
            $this->setValueToDestinationObject(
                $reflectionDestinationProperty,
                $destinationObject,
                $this->convertValue(
                    (new ReflectionPropertyExtractor)->retrievePropertyData(
                        $reflectionDestinationProperty,
                        $sourceReflection,
                        $sourceObject
                    ),
                    $reflectionDestinationProperty
                )
            );
        } catch (SourcePropertyNotFoundException) {
            return;
        }
    }

    private function convertValue(
        SourcePropertyDataDto $sourcePropertyDataDto,
        ReflectionProperty $reflectionDestinationProperty
    ): mixed
    {
        $destinationType = $reflectionDestinationProperty->getType();
        $sourceType = $sourcePropertyDataDto->getProperty()->getType();

        if ($destinationType->getName() !== $sourceType->getName()) {
            if (is_a($destinationType->getName(), DateTimeInterface::class, true)) {
                $destinationTypeName = $destinationType->getName();
                return match ($sourceType->getName()) {
                    'string' => new $destinationTypeName($sourcePropertyDataDto->getValue()),
                    'int' => (new $destinationTypeName())->setTimestamp($sourcePropertyDataDto->getValue()),
                    default => throw new UnsupportedConversionTypeException()
                };
            }
            if (is_a($sourceType->getName(), DateTimeInterface::class, true)) {
                return match ($destinationType->getName()) {
                    'string' => $sourcePropertyDataDto->getValue()->format(DateTimeInterface::ATOM),
                    'int' => $sourcePropertyDataDto->getValue()->getTimestamp(),
                };
            }
        }

        return $sourcePropertyDataDto->getValue();
    }

    private function setValueToDestinationObject(
        ReflectionProperty $reflectionDestinationProperty,
        object             $destinationObject,
        mixed              $value
    ): void
    {
        $reflectionDestinationProperty->setValue($destinationObject, $value);
    }
}