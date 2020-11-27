<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\ComplexGenericsExample;

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
    public function getVariant(\_PhpScoper88fe6e0ad041\ComplexGenericsExample\ExperimentInterface $experiment) : \_PhpScoper88fe6e0ad041\ComplexGenericsExample\VariantInterface;
}
/**
 * @implements ExperimentInterface<SomeVariant>
 */
class SomeExperiment implements \_PhpScoper88fe6e0ad041\ComplexGenericsExample\ExperimentInterface
{
}
class SomeVariant implements \_PhpScoper88fe6e0ad041\ComplexGenericsExample\VariantInterface
{
}
class SomeClass
{
    private $variantRetriever;
    public function __construct(\_PhpScoper88fe6e0ad041\ComplexGenericsExample\VariantRetrieverInterface $variantRetriever)
    {
        $this->variantRetriever = $variantRetriever;
    }
    public function someFunction() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\ComplexGenericsExample\\SomeVariant', $this->variantRetriever->getVariant(new \_PhpScoper88fe6e0ad041\ComplexGenericsExample\SomeExperiment()));
    }
}
