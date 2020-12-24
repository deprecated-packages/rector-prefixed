<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Laravel\Rector\StaticCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/laravel/framework/pull/27276
 * @see \Rector\Laravel\Tests\Rector\StaticCall\RequestStaticValidateToInjectRector\RequestStaticValidateToInjectRectorTest
 */
final class RequestStaticValidateToInjectRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const REQUEST_TYPES = ['_PhpScoper0a6b37af0871\\Illuminate\\Http\\Request', 'Request'];
    /**
     * @var ClassMethodManipulator
     */
    private $classMethodManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator $classMethodManipulator)
    {
        $this->classMethodManipulator = $classMethodManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change static validate() method to $request->validate()', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param StaticCall|FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $requestName = $this->classMethodManipulator->addMethodParameterIfMissing($node, '_PhpScoper0a6b37af0871\\Illuminate\\Http\\Request', ['request', 'httpRequest']);
        $variable = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($requestName);
        $methodName = $this->getName($node->name);
        if ($methodName === null) {
            return null;
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            if ($node->args === []) {
                return $variable;
            }
            $methodName = 'input';
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($variable, new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier($methodName), $node->args);
    }
    /**
     * @param StaticCall|FuncCall $node
     */
    private function shouldSkip(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return !$this->isObjectTypes($node, self::REQUEST_TYPES);
        }
        $classLike = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return \true;
        }
        return !$this->isName($node, 'request');
    }
}
