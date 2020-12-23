<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php74\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\String_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/reflectiontype.tostring.php
 * @see https://www.reddit.com/r/PHP/comments/apikof/whats_the_deal_with_reflectiontype/
 * @see https://3v4l.org/fYeif
 * @see https://3v4l.org/QeM6U
 *
 * @see \Rector\Php74\Tests\Rector\MethodCall\ChangeReflectionTypeToStringToGetNameRector\ChangeReflectionTypeToStringToGetNameRectorTest
 */
final class ChangeReflectionTypeToStringToGetNameRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const GET_NAME = 'getName';
    /**
     * Possibly extract node decorator with scope breakers (Function_, If_) to respect node flow
     * @var string[][]
     */
    private $callsByVariable = [];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change string calls on ReflectionType', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function go(ReflectionFunction $reflectionFunction)
    {
        $parameterReflection = $reflectionFunction->getParameters()[0];

        $paramType = (string) $parameterReflection->getType();

        $stringValue = 'hey' . $reflectionFunction->getReturnType();

        // keep
        return $reflectionFunction->getReturnType();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function go(ReflectionFunction $reflectionFunction)
    {
        $parameterReflection = $reflectionFunction->getParameters()[0];

        $paramType = (string) ($parameterReflection->getType() ? $parameterReflection->getType()->getName() : null);

        $stringValue = 'hey' . ($reflectionFunction->getReturnType() ? $reflectionFunction->getReturnType()->getName() : null);

        // keep
        return $reflectionFunction->getReturnType();
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\String_::class];
    }
    /**
     * @param MethodCall|String_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return $this->refactorMethodCall($node);
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\String_) {
            if ($node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
                return $this->refactorIfHasReturnTypeWasCalled($node->expr);
            }
            if ($node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable && $this->isObjectType($node->expr, 'ReflectionType')) {
                return $this->createMethodCall($node->expr, self::GET_NAME);
            }
        }
        return null;
    }
    private function refactorMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $this->collectCallByVariable($methodCall);
        if ($this->shouldSkipMethodCall($methodCall)) {
            return null;
        }
        if ($this->isReflectionParameterGetTypeMethodCall($methodCall)) {
            return $this->refactorReflectionParameterGetName($methodCall);
        }
        if ($this->isReflectionFunctionAbstractGetReturnTypeMethodCall($methodCall)) {
            return $this->refactorReflectionFunctionGetReturnType($methodCall);
        }
        return null;
    }
    private function refactorIfHasReturnTypeWasCalled(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$methodCall->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return null;
        }
        $variableName = $this->getName($methodCall->var);
        $callsByVariable = $this->callsByVariable[$variableName] ?? [];
        // we already know it has return type
        if (\in_array('hasReturnType', $callsByVariable, \true)) {
            return $this->createMethodCall($methodCall, self::GET_NAME);
        }
        return null;
    }
    private function collectCallByVariable(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        // bit workaround for now
        if ($methodCall->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            $variableName = $this->getName($methodCall->var);
            $methodName = $this->getName($methodCall->name);
            if (!$variableName) {
                return;
            }
            if (!$methodName) {
                return;
            }
            $this->callsByVariable[$variableName][] = $methodName;
        }
    }
    private function shouldSkipMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $scope = $methodCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        // just added node → skip it
        if ($scope === null) {
            return \true;
        }
        // is to string retype?
        $parentNode = $methodCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\String_) {
            return \false;
        }
        // probably already converted
        return !$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
    }
    private function isReflectionParameterGetTypeMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->isObjectType($methodCall->var, 'ReflectionParameter')) {
            return \false;
        }
        return $this->isName($methodCall->name, 'getType');
    }
    private function refactorReflectionParameterGetName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary
    {
        $getNameMethodCall = $this->createMethodCall($methodCall, self::GET_NAME);
        $ternary = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary($methodCall, $getNameMethodCall, $this->createNull());
        // to prevent looping
        $methodCall->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $ternary);
        return $ternary;
    }
    private function isReflectionFunctionAbstractGetReturnTypeMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->isObjectType($methodCall->var, 'ReflectionFunctionAbstract')) {
            return \false;
        }
        return $this->isName($methodCall->name, 'getReturnType');
    }
    private function refactorReflectionFunctionGetReturnType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $refactoredMethodCall = $this->refactorIfHasReturnTypeWasCalled($methodCall);
        if ($refactoredMethodCall !== null) {
            return $refactoredMethodCall;
        }
        $getNameMethodCall = $this->createMethodCall($methodCall, self::GET_NAME);
        $ternary = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary($methodCall, $getNameMethodCall, $this->createNull());
        // to prevent looping
        $methodCall->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $ternary);
        return $ternary;
    }
}
