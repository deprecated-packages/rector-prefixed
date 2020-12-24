<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\MagicDisclosure\Rector\Isset_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Isset_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Unset_;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Webmozart\Assert\Assert;
/**
 * @see \Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\UnsetAndIssetToMethodCallRectorTest
 */
final class UnsetAndIssetToMethodCallRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const ISSET_UNSET_TO_METHOD_CALL = 'isset_unset_to_method_call';
    /**
     * @var IssetUnsetToMethodCall[]
     */
    private $issetUnsetToMethodCalls = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $issetUnsetToMethodCall = new \_PhpScoper0a6b37af0871\Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall('SomeContainer', 'hasService', 'removeService');
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined `__isset`/`__unset` calls to specific method calls.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$container = new SomeContainer;
isset($container["someKey"]);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$container = new SomeContainer;
$container->hasService("someKey");
CODE_SAMPLE
, [self::ISSET_UNSET_TO_METHOD_CALL => [$issetUnsetToMethodCall]]), new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$container = new SomeContainer;
unset($container["someKey"]);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$container = new SomeContainer;
$container->removeService("someKey");
CODE_SAMPLE
, [self::ISSET_UNSET_TO_METHOD_CALL => [$issetUnsetToMethodCall]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Isset_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Unset_::class];
    }
    /**
     * @param Isset_|Unset_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach ($node->vars as $arrayDimFetchNode) {
            if (!$arrayDimFetchNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
                continue;
            }
            foreach ($this->issetUnsetToMethodCalls as $issetUnsetToMethodCall) {
                if (!$this->isObjectType($arrayDimFetchNode, $issetUnsetToMethodCall->getType())) {
                    continue;
                }
                $newNode = $this->processArrayDimFetchNode($node, $arrayDimFetchNode, $issetUnsetToMethodCall);
                if ($newNode !== null) {
                    return $newNode;
                }
            }
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $issetUnsetToMethodCalls = $configuration[self::ISSET_UNSET_TO_METHOD_CALL] ?? [];
        \_PhpScoper0a6b37af0871\Webmozart\Assert\Assert::allIsInstanceOf($issetUnsetToMethodCalls, \_PhpScoper0a6b37af0871\Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall::class);
        $this->issetUnsetToMethodCalls = $issetUnsetToMethodCalls;
    }
    private function processArrayDimFetchNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScoper0a6b37af0871\Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall $issetUnsetToMethodCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Isset_) {
            if ($issetUnsetToMethodCall->getIssetMethodCall() === '') {
                return null;
            }
            return $this->createMethodCall($arrayDimFetch->var, $issetUnsetToMethodCall->getIssetMethodCall(), [$arrayDimFetch->dim]);
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Unset_) {
            if ($issetUnsetToMethodCall->getUnsedMethodCall() === '') {
                return null;
            }
            return $this->createMethodCall($arrayDimFetch->var, $issetUnsetToMethodCall->getUnsedMethodCall(), [$arrayDimFetch->dim]);
        }
        return null;
    }
}
