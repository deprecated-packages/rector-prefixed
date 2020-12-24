<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Laravel\Rector\StaticCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/laravel/framework/pull/27276
 * @see \Rector\Laravel\Tests\Rector\StaticCall\RequestStaticValidateToInjectRector\RequestStaticValidateToInjectRectorTest
 */
final class RequestStaticValidateToInjectRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const REQUEST_TYPES = ['_PhpScopere8e811afab72\\Illuminate\\Http\\Request', 'Request'];
    /**
     * @var ClassMethodManipulator
     */
    private $classMethodManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator $classMethodManipulator)
    {
        $this->classMethodManipulator = $classMethodManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change static validate() method to $request->validate()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Illuminate\Http\Request;

class SomeClass
{
    public function store()
    {
        $validatedData = Request::validate(['some_attribute' => 'required']);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Illuminate\Http\Request;

class SomeClass
{
    public function store(\Illuminate\Http\Request $request)
    {
        $validatedData = $request->validate(['some_attribute' => 'required']);
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param StaticCall|FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $requestName = $this->classMethodManipulator->addMethodParameterIfMissing($node, '_PhpScopere8e811afab72\\Illuminate\\Http\\Request', ['request', 'httpRequest']);
        $variable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($requestName);
        $methodName = $this->getName($node->name);
        if ($methodName === null) {
            return null;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            if ($node->args === []) {
                return $variable;
            }
            $methodName = 'input';
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($variable, new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($methodName), $node->args);
    }
    /**
     * @param StaticCall|FuncCall $node
     */
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return !$this->isObjectTypes($node, self::REQUEST_TYPES);
        }
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return \true;
        }
        return !$this->isName($node, 'request');
    }
}
