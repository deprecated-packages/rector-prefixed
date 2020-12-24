<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionMethod;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/RFYmn
 *
 * @see \Rector\CodingStyle\Tests\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector\MakeInheritedMethodVisibilitySameAsParentRectorTest
 */
final class MakeInheritedMethodVisibilitySameAsParentRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make method visibility same as parent one', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            // possibly trait
            return null;
        }
        $classReflection = $scope->getClassReflection();
        if ($classReflection === null) {
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
    private function isClassMethodCompatibleWithParentReflectionMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \ReflectionMethod $reflectionMethod) : bool
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
    private function isConstructorWithStaticFactory(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, string $methodName) : bool
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::PARENT_VISIBILITY_OVERRIDE)) {
            return \false;
        }
        if ($methodName !== \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
            return \false;
        }
        /** @var Class_|null $classLike */
        $classLike = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
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
    private function changeClassMethodVisibilityBasedOnReflectionMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \ReflectionMethod $reflectionMethod) : void
    {
        if ($reflectionMethod->isPublic()) {
            $this->makePublic($classMethod);
            return;
        }
        if ($reflectionMethod->isProtected()) {
            $this->makeProtected($classMethod);
            return;
        }
        if ($reflectionMethod->isPrivate()) {
            $this->makePrivate($classMethod);
            return;
        }
    }
    /**
     * Looks for:
     * public static someMethod() { return new self(); }
     * or
     * public static someMethod() { return new static(); }
     */
    private function isStaticNamedConstructor(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$classMethod->isPublic()) {
            return \false;
        }
        if (!$classMethod->isStatic()) {
            return \false;
        }
        return (bool) $this->betterNodeFinder->findFirst($classMethod, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
                return \false;
            }
            if (!$node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
                return \false;
            }
            return $this->isNames($node->expr->class, ['self', 'static']);
        });
    }
}
