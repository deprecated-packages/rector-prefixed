<?php

declare (strict_types=1);
namespace Rector\DowngradePhp72\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Interface_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionMethod;
use ReflectionParameter;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/migration72.new-features.php#migration72.new-features.param-type-widening
 *
 * @see \Rector\DowngradePhp72\Tests\Rector\ClassMethod\DowngradeParameterTypeWideningRector\DowngradeParameterTypeWideningRectorTest
 */
final class DowngradeParameterTypeWideningRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    public function __construct(\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger)
    {
        $this->rectorChangeCollector = $rectorChangeCollector;
        $this->phpDocTypeChanger = $phpDocTypeChanger;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove argument type declarations in the parent and in all child classes, whenever some child class removes it', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
interface A
{
    public function test(array $input);
}

class B implements A
{
    public function test($input){} // type omitted for $input
}

class C implements A
{
    public function test(array $input){}
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
interface A
{
    /**
     * @param array $input
     */
    public function test($input);
}

class B implements A
{
    public function test($input){} // type omitted for $input
}

class C implements A
{
    /**
     * @param array $input
     */
    public function test($input);
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Function_::class, \PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod|Function_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->params === null) {
            return null;
        }
        if ($node->params === []) {
            return null;
        }
        foreach ($node->params as $position => $param) {
            $this->refactorParamForAncestorsAndSiblings($param, $node, (int) $position);
        }
        return null;
    }
    private function refactorParamForAncestorsAndSiblings(\PhpParser\Node\Param $param, \PhpParser\Node\FunctionLike $functionLike, int $position) : void
    {
        // The param on the child class must have no type
        if ($param->type !== null) {
            return;
        }
        /** @var Scope|null $scope */
        $scope = $functionLike->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            // possibly trait
            return;
        }
        $classReflection = $scope->getClassReflection();
        if ($classReflection === null) {
            return;
        }
        /** @var string $methodName */
        $methodName = $this->getName($functionLike);
        $paramName = $this->getName($param);
        // Obtain the list of the ancestors classes and implemented interfaces
        // with a different signature
        $ancestorAndInterfaceClassNames = \array_merge($this->getClassesWithDifferentSignature($classReflection, $methodName, $paramName), $this->getInterfacesWithDifferentSignature($classReflection, $methodName, $paramName));
        // Remove the types in:
        // - all ancestors + their descendant classes
        // - all implemented interfaces + their implementing classes
        foreach ($ancestorAndInterfaceClassNames as $ancestorClassOrInterface) {
            /** @var string $parentClassName */
            $parentClassName = $ancestorClassOrInterface->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            $classMethod = $this->nodeRepository->findClassMethod($parentClassName, $methodName);
            /**
             * If it doesn't find the method, it's because the method
             * lives somewhere else.
             * For instance, in test "interface_on_parent_class.php.inc",
             * the ancestor abstract class is also retrieved
             * as containing the method, but it does not: it is
             * in its implemented interface. That happens because
             * `ReflectionMethod` doesn't allow to do do the distinction.
             * The interface is also retrieve though, so that method
             * will eventually be refactored.
             */
            if ($classMethod === null) {
                continue;
            }
            $this->removeParamTypeFromMethod($ancestorClassOrInterface, $position, $classMethod);
            $this->removeParamTypeFromMethodForChildren($parentClassName, $methodName, $position);
        }
    }
    /**
     * Obtain the list of the ancestors classes with a different signature
     * @return Class_[]
     */
    private function getClassesWithDifferentSignature(\PHPStan\Reflection\ClassReflection $classReflection, string $methodName, string $paramName) : array
    {
        // 1. All ancestor classes with different signature
        $refactorableAncestorClassNames = \array_filter($classReflection->getParentClassesNames(), function (string $ancestorClassName) use($methodName, $paramName) : bool {
            return $this->hasMethodWithTypedParam($ancestorClassName, $methodName, $paramName);
        });
        return \array_filter(\array_map(function (string $ancestorClassName) : ?Class_ {
            return $this->nodeRepository->findClass($ancestorClassName);
        }, $refactorableAncestorClassNames));
    }
    /**
     * Obtain the list of the implemented interfaces with a different signature
     * @return Interface_[]
     */
    private function getInterfacesWithDifferentSignature(\PHPStan\Reflection\ClassReflection $classReflection, string $methodName, string $paramName) : array
    {
        $interfaceClassNames = \array_map(function (\PHPStan\Reflection\ClassReflection $interfaceReflection) : string {
            return $interfaceReflection->getName();
        }, $classReflection->getInterfaces());
        $refactorableInterfaceClassNames = \array_filter($interfaceClassNames, function (string $interfaceClassName) use($methodName, $paramName) : bool {
            return $this->hasMethodWithTypedParam($interfaceClassName, $methodName, $paramName);
        });
        return \array_filter(\array_map(function (string $interfaceClassName) : ?Interface_ {
            return $this->nodeRepository->findInterface($interfaceClassName);
        }, $refactorableInterfaceClassNames));
    }
    private function removeParamTypeFromMethod(\PhpParser\Node\Stmt\ClassLike $classLike, int $position, \PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $classMethodName = $this->getName($classMethod);
        $currentClassMethod = $classLike->getMethod($classMethodName);
        if ($currentClassMethod === null) {
            return;
        }
        if (!isset($currentClassMethod->params[$position])) {
            return;
        }
        $param = $currentClassMethod->params[$position];
        // It already has no type => nothing to do
        if ($param->type === null) {
            return;
        }
        // Add the current type in the PHPDoc
        $this->addPHPDocParamTypeToMethod($classMethod, $param);
        // Remove the type
        $param->type = null;
        $this->rectorChangeCollector->notifyNodeFileInfo($param);
    }
    private function removeParamTypeFromMethodForChildren(string $parentClassName, string $methodName, int $position) : void
    {
        $childrenClassLikes = $this->nodeRepository->findClassesAndInterfacesByType($parentClassName);
        foreach ($childrenClassLikes as $childClassLike) {
            $childClassName = $childClassLike->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($childClassName === null) {
                continue;
            }
            $childClassMethod = $this->nodeRepository->findClassMethod($childClassName, $methodName);
            if ($childClassMethod === null) {
                continue;
            }
            $this->removeParamTypeFromMethod($childClassLike, $position, $childClassMethod);
        }
    }
    private function hasMethodWithTypedParam(string $parentClassName, string $methodName, string $paramName) : bool
    {
        if (!\method_exists($parentClassName, $methodName)) {
            return \false;
        }
        $parentReflectionMethod = new \ReflectionMethod($parentClassName, $methodName);
        /** @var ReflectionParameter[] */
        $parentReflectionMethodParams = $parentReflectionMethod->getParameters();
        foreach ($parentReflectionMethodParams as $reflectionParameter) {
            if ($reflectionParameter->name === $paramName && $reflectionParameter->getType() !== null) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * Add the current param type in the PHPDoc
     */
    private function addPHPDocParamTypeToMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Param $param) : void
    {
        if ($param->type === null) {
            return;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $paramName = $this->getName($param);
        $mappedCurrentParamType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
        $this->phpDocTypeChanger->changeParamType($phpDocInfo, $mappedCurrentParamType, $param, $paramName);
    }
}
