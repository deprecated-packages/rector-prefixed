<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DowngradePhp72\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionMethod;
use ReflectionParameter;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/migration72.new-features.php#migration72.new-features.param-type-widening
 *
 * @see \Rector\DowngradePhp72\Tests\Rector\ClassMethod\DowngradeParameterTypeWideningRector\DowngradeParameterTypeWideningRectorTest
 */
final class DowngradeParameterTypeWideningRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector)
    {
        $this->rectorChangeCollector = $rectorChangeCollector;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove argument type declarations in the parent and in all child classes, whenever some child class removes it', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod|Function_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node->params === null || $node->params === []) {
            return null;
        }
        foreach ($node->params as $position => $param) {
            $this->refactorParamForAncestorsAndSiblings($param, $node, (int) $position);
        }
        return null;
    }
    private function refactorParamForAncestorsAndSiblings(\_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param, \_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $functionLike, int $position) : void
    {
        // The param on the child class must have no type
        if ($param->type !== null) {
            return;
        }
        /** @var Scope|null $scope */
        $scope = $functionLike->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
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
            /** @var string */
            $parentClassName = $ancestorClassOrInterface->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
    private function getClassesWithDifferentSignature(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $methodName, string $paramName) : array
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
    private function getInterfacesWithDifferentSignature(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $methodName, string $paramName) : array
    {
        $interfaceClassNames = \array_map(function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $interfaceReflection) : string {
            return $interfaceReflection->getName();
        }, $classReflection->getInterfaces());
        $refactorableInterfaceClassNames = \array_filter($interfaceClassNames, function (string $interfaceClassName) use($methodName, $paramName) : bool {
            return $this->hasMethodWithTypedParam($interfaceClassName, $methodName, $paramName);
        });
        return \array_filter(\array_map(function (string $interfaceClassName) : ?Interface_ {
            return $this->nodeRepository->findInterface($interfaceClassName);
        }, $refactorableInterfaceClassNames));
    }
    private function removeParamTypeFromMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $classLike, int $position, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
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
            $childClassName = $childClassLike->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
    private function addPHPDocParamTypeToMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param) : void
    {
        if ($param->type === null) {
            return;
        }
        /** @var PhpDocInfo|null */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($classMethod);
        }
        $paramName = $this->getName($param);
        $mappedCurrentParamType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
        $phpDocInfo->changeParamType($mappedCurrentParamType, $param, $paramName);
    }
}
