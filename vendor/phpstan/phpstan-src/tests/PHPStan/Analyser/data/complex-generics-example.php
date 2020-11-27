<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\ComplexGenericsExample;

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
    public function getVariant(\_PhpScoper006a73f0e455\ComplexGenericsExample\ExperimentInterface $experiment) : \_PhpScoper006a73f0e455\ComplexGenericsExample\VariantInterface;
}
/**
 * @implements ExperimentInterface<SomeVariant>
 */
class SomeExperiment implements \_PhpScoper006a73f0e455\ComplexGenericsExample\ExperimentInterface
{
}
class SomeVariant implements \_PhpScoper006a73f0e455\ComplexGenericsExample\VariantInterface
{
}
class SomeClass
{
    private $variantRetriever;
    public function __construct(\_PhpScoper006a73f0e455\ComplexGenericsExample\VariantRetrieverInterface $variantRetriever)
    {
        $this->variantRetriever = $variantRetriever;
    }
    public function someFunction() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\ComplexGenericsExample\\SomeVariant', $this->variantRetriever->getVariant(new \_PhpScoper006a73f0e455\ComplexGenericsExample\SomeExperiment()));
    }
}
