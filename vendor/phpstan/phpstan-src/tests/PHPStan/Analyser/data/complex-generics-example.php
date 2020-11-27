<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\ComplexGenericsExample;

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
    public function getVariant(\_PhpScopera143bcca66cb\ComplexGenericsExample\ExperimentInterface $experiment) : \_PhpScopera143bcca66cb\ComplexGenericsExample\VariantInterface;
}
/**
 * @implements ExperimentInterface<SomeVariant>
 */
class SomeExperiment implements \_PhpScopera143bcca66cb\ComplexGenericsExample\ExperimentInterface
{
}
class SomeVariant implements \_PhpScopera143bcca66cb\ComplexGenericsExample\VariantInterface
{
}
class SomeClass
{
    private $variantRetriever;
    public function __construct(\_PhpScopera143bcca66cb\ComplexGenericsExample\VariantRetrieverInterface $variantRetriever)
    {
        $this->variantRetriever = $variantRetriever;
    }
    public function someFunction() : void
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\ComplexGenericsExample\\SomeVariant', $this->variantRetriever->getVariant(new \_PhpScopera143bcca66cb\ComplexGenericsExample\SomeExperiment()));
    }
}
