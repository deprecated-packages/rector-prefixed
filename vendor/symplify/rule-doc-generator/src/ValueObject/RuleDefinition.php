<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject;

use RectorPrefix20201228\Nette\Utils\Strings;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Exception\PoorDocumentationException;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use RectorPrefix20201228\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class RuleDefinition
{
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $ruleClass;
    /**
     * @var CodeSampleInterface[]
     */
    private $codeSamples = [];
    /**
     * @param CodeSampleInterface[] $codeSamples
     */
    public function __construct(string $description, array $codeSamples)
    {
        $this->description = $description;
        if ($codeSamples === []) {
            throw new \RectorPrefix20201228\Symplify\RuleDocGenerator\Exception\PoorDocumentationException('Provide at least one code sample, so people can practically see what the rule does');
        }
        $this->codeSamples = $codeSamples;
    }
    public function getDescription() : string
    {
        return $this->description;
    }
    public function setRuleClass(string $ruleClass) : void
    {
        $this->ruleClass = $ruleClass;
    }
    public function getRuleClass() : string
    {
        if ($this->ruleClass === null) {
            throw new \RectorPrefix20201228\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->ruleClass;
    }
    public function getRuleShortClass() : string
    {
        return (string) \RectorPrefix20201228\Nette\Utils\Strings::after($this->ruleClass, '\\', -1);
    }
    /**
     * @return CodeSampleInterface[]
     */
    public function getCodeSamples() : array
    {
        return $this->codeSamples;
    }
    public function isConfigurable() : bool
    {
        foreach ($this->codeSamples as $codeSample) {
            if ($codeSample instanceof \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample) {
                return \true;
            }
        }
        return \false;
    }
}
