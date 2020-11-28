<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\ComplexGenericsExample;

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
    public function getVariant(\_PhpScoperabd03f0baf05\ComplexGenericsExample\ExperimentInterface $experiment) : \_PhpScoperabd03f0baf05\ComplexGenericsExample\VariantInterface;
}
/**
 * @implements ExperimentInterface<SomeVariant>
 */
class SomeExperiment implements \_PhpScoperabd03f0baf05\ComplexGenericsExample\ExperimentInterface
{
}
class SomeVariant implements \_PhpScoperabd03f0baf05\ComplexGenericsExample\VariantInterface
{
}
class SomeClass
{
    private $variantRetriever;
    public function __construct(\_PhpScoperabd03f0baf05\ComplexGenericsExample\VariantRetrieverInterface $variantRetriever)
    {
        $this->variantRetriever = $variantRetriever;
    }
    public function someFunction() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\ComplexGenericsExample\\SomeVariant', $this->variantRetriever->getVariant(new \_PhpScoperabd03f0baf05\ComplexGenericsExample\SomeExperiment()));
    }
}
