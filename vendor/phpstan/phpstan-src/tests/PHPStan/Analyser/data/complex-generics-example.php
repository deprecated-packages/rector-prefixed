<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\ComplexGenericsExample;

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
    public function getVariant(\_PhpScoperbd5d0c5f7638\ComplexGenericsExample\ExperimentInterface $experiment) : \_PhpScoperbd5d0c5f7638\ComplexGenericsExample\VariantInterface;
}
/**
 * @implements ExperimentInterface<SomeVariant>
 */
class SomeExperiment implements \_PhpScoperbd5d0c5f7638\ComplexGenericsExample\ExperimentInterface
{
}
class SomeVariant implements \_PhpScoperbd5d0c5f7638\ComplexGenericsExample\VariantInterface
{
}
class SomeClass
{
    private $variantRetriever;
    public function __construct(\_PhpScoperbd5d0c5f7638\ComplexGenericsExample\VariantRetrieverInterface $variantRetriever)
    {
        $this->variantRetriever = $variantRetriever;
    }
    public function someFunction() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\ComplexGenericsExample\\SomeVariant', $this->variantRetriever->getVariant(new \_PhpScoperbd5d0c5f7638\ComplexGenericsExample\SomeExperiment()));
    }
}
