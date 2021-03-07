<?php

declare (strict_types=1);
namespace Rector\Privatization\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ObjectType;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Privatization\NodeAnalyzer\ClassMethodExternalCallNodeAnalyzer;
use Rector\Privatization\VisibilityGuard\ChildClassMethodOverrideGuard;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Privatization\Tests\Rector\ClassMethod\MakeOnlyUsedByChildrenProtectedRector\MakeOnlyUsedByChildrenProtectedRectorTest
 */
final class MakeOnlyUsedByChildrenProtectedRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassMethodExternalCallNodeAnalyzer
     */
    private $classMethodExternalCallNodeAnalyzer;
    /**
     * @var ChildClassMethodOverrideGuard
     */
    private $childClassMethodOverrideGuard;
    public function __construct(\Rector\Privatization\NodeAnalyzer\ClassMethodExternalCallNodeAnalyzer $classMethodExternalCallNodeAnalyzer, \Rector\Privatization\VisibilityGuard\ChildClassMethodOverrideGuard $childClassMethodOverrideGuard)
    {
        $this->classMethodExternalCallNodeAnalyzer = $classMethodExternalCallNodeAnalyzer;
        $this->childClassMethodOverrideGuard = $childClassMethodOverrideGuard;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make public class method protected, if only used by its children', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
abstract class AbstractSomeClass
{
    public function run()
    {
    }
}

class ChildClass extends AbstractSomeClass
{
    public function go()
    {
        $this->run();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
abstract class AbstractSomeClass
{
    protected function run()
    {
    }
}

class ChildClass extends AbstractSomeClass
{
    public function go()
    {
        $this->run();
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $externalCalls = $this->classMethodExternalCallNodeAnalyzer->getExternalCalls($node);
        if ($externalCalls === []) {
            return null;
        }
        /** @var string $className */
        $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($externalCalls as $externalCall) {
            $class = $externalCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if (!$class instanceof \PhpParser\Node\Stmt\Class_) {
                return null;
            }
            if (!$this->isObjectType($class, new \PHPStan\Type\ObjectType($className))) {
                return null;
            }
        }
        $methodName = $this->getName($node);
        if ($this->childClassMethodOverrideGuard->isOverriddenInChildClass($scope, $methodName)) {
            return null;
        }
        $this->visibilityManipulator->makeProtected($node);
        return $node;
    }
    private function shouldSkip(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $currentClass = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$currentClass instanceof \PhpParser\Node\Stmt\Class_) {
            return \true;
        }
        if ($currentClass->isFinal()) {
            return \true;
        }
        if ($currentClass->extends instanceof \PhpParser\Node\Name\FullyQualified) {
            return \true;
        }
        if ($currentClass->isAbstract() && $this->isOpenSourceProjectType()) {
            return \true;
        }
        $className = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \true;
        }
        return !$classMethod->isPublic();
    }
}
