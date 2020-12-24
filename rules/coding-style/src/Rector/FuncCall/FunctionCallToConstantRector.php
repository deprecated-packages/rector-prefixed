<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\FuncCall\FunctionCallToConstantRector\FunctionCallToConstantRectorTest
 */
final class FunctionCallToConstantRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const FUNCTIONS_TO_CONSTANTS = 'functions_to_constants';
    /**
     * @var string[]
     */
    private $functionsToConstants = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes use of function calls to use constants', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = php_sapi_name();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = PHP_SAPI;
    }
}
CODE_SAMPLE
, [self::FUNCTIONS_TO_CONSTANTS => ['php_sapi_name' => 'PHP_SAPI']]), new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = pi();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = M_PI;
    }
}
CODE_SAMPLE
, [self::FUNCTIONS_TO_CONSTANTS => ['pi' => 'M_PI']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $functionName = $this->getName($node);
        if (!$functionName || !\array_key_exists($functionName, $this->functionsToConstants)) {
            return null;
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Name($this->functionsToConstants[$functionName]));
    }
    public function configure(array $configuration) : void
    {
        $this->functionsToConstants = $configuration[self::FUNCTIONS_TO_CONSTANTS] ?? [];
    }
}
