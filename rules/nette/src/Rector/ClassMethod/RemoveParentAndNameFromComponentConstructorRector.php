<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\Nette\Application\UI\Control;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\Nette\NodeAnalyzer\StaticCallAnalyzer;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\Reflection\MethodReflectionProvider;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/nette/component-model/commit/1fb769f4602cf82694941530bac1111b3c5cd11b
 *
 * @see \Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\RemoveParentAndNameFromComponentConstructorRectorTest
 */
final class RemoveParentAndNameFromComponentConstructorRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const COMPONENT_CONTAINER_CLASS = '_PhpScoper0a6b37af0871\\Nette\\ComponentModel\\IContainer';
    /**
     * @var string
     */
    private const PARENT = 'parent';
    /**
     * @var string
     */
    private const NAME = 'name';
    /**
     * @var StaticCallAnalyzer
     */
    private $staticCallAnalyzer;
    /**
     * @var MethodReflectionProvider
     */
    private $methodReflectionProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Nette\NodeAnalyzer\StaticCallAnalyzer $staticCallAnalyzer, \_PhpScoper0a6b37af0871\Rector\NodeCollector\Reflection\MethodReflectionProvider $methodReflectionProvider)
    {
        $this->staticCallAnalyzer = $staticCallAnalyzer;
        $this->methodReflectionProvider = $methodReflectionProvider;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove $parent and $name in control constructor', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Application\UI\Control;

class SomeControl extends Control
{
    public function __construct(IContainer $parent = null, $name = null, int $value)
    {
        parent::__construct($parent, $name);
        $this->value = $value;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Application\UI\Control;

class SomeControl extends Control
{
    public function __construct(int $value)
    {
        $this->value = $value;
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param ClassMethod|StaticCall|New_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
            return $this->refactorClassMethod($node);
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return $this->refactorStaticCall($node);
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_ && $this->isObjectType($node->class, self::COMPONENT_CONTAINER_CLASS)) {
            return $this->refactorNew($node);
        }
        return null;
    }
    private function refactorClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        if (!$this->isInObjectType($classMethod, \_PhpScoper0a6b37af0871\Nette\Application\UI\Control::class)) {
            return null;
        }
        if (!$this->isName($classMethod, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return null;
        }
        $hasClassMethodChanged = \false;
        foreach ($classMethod->params as $param) {
            if ($this->isName($param, self::PARENT) && $param->type !== null && $this->isName($param->type, self::COMPONENT_CONTAINER_CLASS)) {
                $this->removeNode($param);
                $hasClassMethodChanged = \true;
            }
            if ($this->isName($param, self::NAME)) {
                $this->removeNode($param);
                $hasClassMethodChanged = \true;
            }
        }
        if (!$hasClassMethodChanged) {
            return null;
        }
        return $classMethod;
    }
    private function refactorStaticCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall
    {
        if (!$this->staticCallAnalyzer->isParentCallNamed($staticCall, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return null;
        }
        $hasStaticCallChanged = \false;
        /** @var Arg $staticCallArg */
        foreach ((array) $staticCall->args as $staticCallArg) {
            if (!$staticCallArg->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
                continue;
            }
            /** @var Variable $variable */
            $variable = $staticCallArg->value;
            if (!$this->isNames($variable, [self::NAME, self::PARENT])) {
                continue;
            }
            $this->removeNode($staticCallArg);
            $hasStaticCallChanged = \true;
        }
        if (!$hasStaticCallChanged) {
            return null;
        }
        if ($this->shouldRemoveEmptyCall($staticCall)) {
            $this->removeNode($staticCall);
            return null;
        }
        return $staticCall;
    }
    private function refactorNew(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_ $new) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_
    {
        $parameterNames = $this->methodReflectionProvider->provideParameterNamesByNew($new);
        $hasNewChanged = \false;
        foreach ($new->args as $position => $arg) {
            // is on position of $parent or $name?
            if (!isset($parameterNames[$position])) {
                continue;
            }
            $parameterName = $parameterNames[$position];
            if (!\in_array($parameterName, [self::PARENT, self::NAME], \true)) {
                continue;
            }
            $hasNewChanged = \true;
            $this->removeNode($arg);
        }
        if (!$hasNewChanged) {
            return null;
        }
        return $new;
    }
    private function shouldRemoveEmptyCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall) : bool
    {
        foreach ($staticCall->args as $arg) {
            if ($this->isNodeRemoved($arg)) {
                continue;
            }
            return \false;
        }
        return \true;
    }
}
