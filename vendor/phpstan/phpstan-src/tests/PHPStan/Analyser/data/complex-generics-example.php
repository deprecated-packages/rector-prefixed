<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\ComplexGenericsExample;

use function PHPStan\Analyser\assertType;
/**
 * @template TVariant of VariantInterface
 */
interface ExperimentInterface
{
}
interface VariantInterface
{
}
interface VariantRetrieverInterface
{
    /**
     * @template TVariant of VariantInterface
     * @param ExperimentInterface<TVariant> $experiment
     * @return TVariant
     */
    public function getVariant(\_PhpScoper26e51eeacccf\ComplexGenericsExample\ExperimentInterface $experiment) : \_PhpScoper26e51eeacccf\ComplexGenericsExample\VariantInterface;
}
/**
 * @implements ExperimentInterface<SomeVariant>
 */
class SomeExperiment implements \_PhpScoper26e51eeacccf\ComplexGenericsExample\ExperimentInterface
{
}
class SomeVariant implements \_PhpScoper26e51eeacccf\ComplexGenericsExample\VariantInterface
{
}
class SomeClass
{
    private $variantRetriever;
    public function __construct(\_PhpScoper26e51eeacccf\ComplexGenericsExample\VariantRetrieverInterface $variantRetriever)
    {
        $this->variantRetriever = $variantRetriever;
    }
    public function someFunction() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\ComplexGenericsExample\\SomeVariant', $this->variantRetriever->getVariant(new \_PhpScoper26e51eeacccf\ComplexGenericsExample\SomeExperiment()));
    }
}
