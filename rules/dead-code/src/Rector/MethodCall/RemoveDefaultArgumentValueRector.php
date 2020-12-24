<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\BuilderHelpers;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionFunction;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\MethodCall\RemoveDefaultArgumentValueRector\RemoveDefaultArgumentValueRectorTest
 */
final class RemoveDefaultArgumentValueRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove argument value, if it is the same as default value', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->runWithDefault([]);
        $card = self::runWithStaticDefault([]);
    }

    public function runWithDefault($items = [])
    {
        return $items;
    }

    public function runStaticWithDefault($cards = [])
    {
        return $cards;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->runWithDefault();
        $card = self::runWithStaticDefault();
    }

    public function runWithDefault($items = [])
    {
        return $items;
    }

    public function runStaticWithDefault($cards = [])
    {
        return $cards;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param MethodCall|StaticCall|FuncCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $defaultValues = $this->resolveDefaultValuesFromCall($node);
        $keysToRemove = $this->resolveKeysToRemove($node, $defaultValues);
        if ($keysToRemove === []) {
            return null;
        }
        foreach ($keysToRemove as $keyToRemove) {
            $this->removeArg($node, $keyToRemove);
        }
        return $node;
    }
    /**
     * @param MethodCall|StaticCall|FuncCall $node
     */
    private function shouldSkip(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        if ($node->args === []) {
            return \true;
        }
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        if (!$node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return \true;
        }
        $functionName = $this->getName($node);
        if ($functionName === null) {
            return \false;
        }
        if (!\function_exists($functionName)) {
            return \false;
        }
        $reflectionFunction = new \ReflectionFunction($functionName);
        // skip native functions, hard to analyze without stubs (stubs would make working with IDE non-practical)
        return $reflectionFunction->isInternal();
    }
    /**
     * @param StaticCall|FuncCall|MethodCall $node
     * @return Node[]
     */
    private function resolveDefaultValuesFromCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        $nodeName = $this->resolveNodeName($node);
        if ($nodeName === null) {
            return [];
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return $this->resolveFuncCallDefaultParamValues($nodeName);
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        // anonymous class
        if ($className === null) {
            return [];
        }
        $classMethodNode = $this->nodeRepository->findClassMethod($className, $nodeName);
        if ($classMethodNode !== null) {
            return $this->resolveDefaultParamValuesFromFunctionLike($classMethodNode);
        }
        return [];
    }
    /**
     * @param StaticCall|MethodCall|FuncCall $node
     * @param Expr[]|mixed[] $defaultValues
     * @return int[]
     */
    private function resolveKeysToRemove(\_PhpScoperb75b35f52b74\PhpParser\Node $node, array $defaultValues) : array
    {
        $keysToRemove = [];
        $keysToKeep = [];
        /** @var int $key */
        foreach ($node->args as $key => $arg) {
            if (!isset($defaultValues[$key])) {
                $keysToKeep[] = $key;
                continue;
            }
            if ($this->areNodesEqual($defaultValues[$key], $arg->value)) {
                $keysToRemove[] = $key;
            } else {
                $keysToKeep[] = $key;
            }
        }
        if ($keysToRemove === []) {
            return [];
        }
        if ($keysToKeep !== [] && \max($keysToKeep) > \max($keysToRemove)) {
            return [];
        }
        /** @var int[] $keysToRemove */
        return $keysToRemove;
    }
    /**
     * @param StaticCall|FuncCall|MethodCall $node
     */
    private function resolveNodeName(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return $this->getName($node);
        }
        return $this->getName($node->name);
    }
    /**
     * @return Node[]|Expr[]
     */
    private function resolveFuncCallDefaultParamValues(string $nodeName) : array
    {
        $functionNode = $this->nodeRepository->findFunction($nodeName);
        if ($functionNode !== null) {
            return $this->resolveDefaultParamValuesFromFunctionLike($functionNode);
        }
        // non existing function
        if (!\function_exists($nodeName)) {
            return [];
        }
        $reflectionFunction = new \ReflectionFunction($nodeName);
        if ($reflectionFunction->isUserDefined()) {
            $defaultValues = [];
            foreach ($reflectionFunction->getParameters() as $key => $reflectionParameter) {
                if ($reflectionParameter->isDefaultValueAvailable()) {
                    $defaultValues[$key] = \_PhpScoperb75b35f52b74\PhpParser\BuilderHelpers::normalizeValue($reflectionParameter->getDefaultValue());
                }
            }
            return $defaultValues;
        }
        return [];
    }
    /**
     * @return Node[]
     */
    private function resolveDefaultParamValuesFromFunctionLike(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : array
    {
        $defaultValues = [];
        foreach ($functionLike->getParams() as $key => $param) {
            if ($param->default === null) {
                continue;
            }
            $defaultValues[$key] = $param->default;
        }
        return $defaultValues;
    }
}
