<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionMethod;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/RFYmn
 *
 * @see \Rector\CodingStyle\Tests\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector\MakeInheritedMethodVisibilitySameAsParentRectorTest
 */
final class MakeInheritedMethodVisibilitySameAsParentRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make method visibility same as parent one', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class ChildClass extends ParentClass
{
    public function run()
    {
    }
}

class ParentClass
{
    protected function run()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class ChildClass extends ParentClass
{
    protected function run()
    {
    }
}

class ParentClass
{
    protected function run()
    {
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            // possibly trait
            return null;
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return null;
        }
        /** @var string $methodName */
        $methodName = $this->getName($node->name);
        foreach ($classReflection->getParentClassesNames() as $parentClassName) {
            if (!\method_exists($parentClassName, $methodName)) {
                continue;
            }
            $parentReflectionMethod = new \ReflectionMethod($parentClassName, $methodName);
            if ($this->isClassMethodCompatibleWithParentReflectionMethod($node, $parentReflectionMethod)) {
                return null;
            }
            if ($this->isConstructorWithStaticFactory($node, $methodName)) {
                return null;
            }
            $this->changeClassMethodVisibilityBasedOnReflectionMethod($node, $parentReflectionMethod);
            return $node;
        }
        return null;
    }
    private function isClassMethodCompatibleWithParentReflectionMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, \ReflectionMethod $reflectionMethod) : bool
    {
        if ($reflectionMethod->isPublic() && $classMethod->isPublic()) {
            return \true;
        }
        if ($reflectionMethod->isProtected() && $classMethod->isProtected()) {
            return \true;
        }
        if (!$reflectionMethod->isPrivate()) {
            return \false;
        }
        return $classMethod->isPrivate();
    }
    /**
     * Parent constructor visibility override is allowed only since PHP 7.2+
     * @see https://3v4l.org/RFYmn
     */
    private function isConstructorWithStaticFactory(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $methodName) : bool
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::PARENT_VISIBILITY_OVERRIDE)) {
            return \false;
        }
        if ($methodName !== \Rector\Core\ValueObject\MethodName::CONSTRUCT) {
            return \false;
        }
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        foreach ($classLike->getMethods() as $iteratedClassMethod) {
            if (!$iteratedClassMethod->isPublic()) {
                continue;
            }
            if (!$iteratedClassMethod->isStatic()) {
                continue;
            }
            $isStaticSelfFactory = $this->isStaticNamedConstructor($iteratedClassMethod);
            if (!$isStaticSelfFactory) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    private function changeClassMethodVisibilityBasedOnReflectionMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, \ReflectionMethod $reflectionMethod) : void
    {
        if ($reflectionMethod->isPublic()) {
            $this->visibilityManipulator->makePublic($classMethod);
            return;
        }
        if ($reflectionMethod->isProtected()) {
            $this->visibilityManipulator->makeProtected($classMethod);
            return;
        }
        if ($reflectionMethod->isPrivate()) {
            $this->visibilityManipulator->makePrivate($classMethod);
            return;
        }
    }
    /**
     * Looks for:
     * public static someMethod() { return new self(); }
     * or
     * public static someMethod() { return new static(); }
     */
    private function isStaticNamedConstructor(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$classMethod->isPublic()) {
            return \false;
        }
        if (!$classMethod->isStatic()) {
            return \false;
        }
        return (bool) $this->betterNodeFinder->findFirst($classMethod, function (\PhpParser\Node $node) : bool {
            if (!$node instanceof \PhpParser\Node\Stmt\Return_) {
                return \false;
            }
            if (!$node->expr instanceof \PhpParser\Node\Expr\New_) {
                return \false;
            }
            return $this->isNames($node->expr->class, ['self', 'static']);
        });
    }
}
