<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagRemover;
use Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use Rector\Core\NodeManipulator\ClassManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\NodeCollector\UnusedParameterResolver;
use Rector\DeadCode\NodeManipulator\MagicMethodDetector;
use Rector\DeadCode\NodeManipulator\VariadicFunctionLikeDetector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/function.compact.php
 *
 * @see \Rector\Tests\DeadCode\Rector\ClassMethod\RemoveUnusedParameterRector\RemoveUnusedParameterRectorTest
 * @see \Rector\Tests\DeadCode\Rector\ClassMethod\RemoveUnusedParameterRector\OpenSourceRectorTest
 */
final class RemoveUnusedParameterRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    /**
     * @var MagicMethodDetector
     */
    private $magicMethodDetector;
    /**
     * @var VariadicFunctionLikeDetector
     */
    private $variadicFunctionLikeDetector;
    /**
     * @var UnusedParameterResolver
     */
    private $unusedParameterResolver;
    /**
     * @var PhpDocTagRemover
     */
    private $phpDocTagRemover;
    public function __construct(\Rector\Core\NodeManipulator\ClassManipulator $classManipulator, \Rector\DeadCode\NodeManipulator\MagicMethodDetector $magicMethodDetector, \Rector\DeadCode\NodeManipulator\VariadicFunctionLikeDetector $variadicFunctionLikeDetector, \Rector\DeadCode\NodeCollector\UnusedParameterResolver $unusedParameterResolver, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagRemover $phpDocTagRemover)
    {
        $this->classManipulator = $classManipulator;
        $this->magicMethodDetector = $magicMethodDetector;
        $this->variadicFunctionLikeDetector = $variadicFunctionLikeDetector;
        $this->unusedParameterResolver = $unusedParameterResolver;
        $this->phpDocTagRemover = $phpDocTagRemover;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused parameter, if not required by interface or parent class', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct($value, $value2)
    {
         $this->value = $value;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct($value)
    {
         $this->value = $value;
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
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        $methodName = $this->getName($node);
        if ($this->classManipulator->hasParentMethodOrInterface(new \PHPStan\Type\ObjectType($className), $methodName)) {
            return null;
        }
        $childrenOfClass = $this->nodeRepository->findChildrenOfClass($className);
        $unusedParameters = $this->unusedParameterResolver->resolve($node, $methodName, $childrenOfClass);
        if ($unusedParameters === []) {
            return null;
        }
        foreach ($childrenOfClass as $childOfClass) {
            $methodOfChild = $childOfClass->getMethod($methodName);
            if (!$methodOfChild instanceof \PhpParser\Node\Stmt\ClassMethod) {
                continue;
            }
            $overlappingParameters = $this->getParameterOverlap($methodOfChild->params, $unusedParameters);
            $this->removeNodes($overlappingParameters);
        }
        $this->removeNodes($unusedParameters);
        $this->clearPhpDocInfo($node, $unusedParameters);
        return $node;
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function shouldSkip($classMethod) : bool
    {
        if ($classMethod->params === []) {
            return \true;
        }
        if ($this->magicMethodDetector->isMagicMethod($classMethod)) {
            return \true;
        }
        if ($this->variadicFunctionLikeDetector->isVariadic($classMethod)) {
            return \true;
        }
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        // skip interfaces and traits
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \true;
        }
        if ($this->shouldSkipOpenSourceAbstract($classMethod, $classLike)) {
            return \true;
        }
        if ($this->shouldSkipOpenSourceEmpty($classMethod)) {
            return \true;
        }
        if ($this->shouldSkipOpenSourceProtectedMethod($classMethod)) {
            return \true;
        }
        return $this->classAnalyzer->isAnonymousClass($classLike);
    }
    /**
     * @param Param[] $parameters1
     * @param Param[] $parameters2
     * @return Param[]
     */
    private function getParameterOverlap($parameters1, $parameters2) : array
    {
        return \array_uintersect($parameters1, $parameters2, function (\PhpParser\Node\Param $firstParam, \PhpParser\Node\Param $secondParam) : int {
            return $this->nodeComparator->areNodesEqual($firstParam, $secondParam) ? 0 : 1;
        });
    }
    /**
     * @param Param[] $unusedParameters
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function clearPhpDocInfo($classMethod, $unusedParameters) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        foreach ($unusedParameters as $unusedParameter) {
            $parameterName = $this->getName($unusedParameter->var);
            if ($parameterName === null) {
                continue;
            }
            $paramTagValueNode = $phpDocInfo->getParamTagValueByName($parameterName);
            if (!$paramTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode) {
                continue;
            }
            if ($paramTagValueNode->parameterName !== '$' . $parameterName) {
                continue;
            }
            $this->phpDocTagRemover->removeTagValueFromNode($phpDocInfo, $paramTagValueNode);
        }
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    private function shouldSkipOpenSourceAbstract($classMethod, $class) : bool
    {
        // skip as possible contract for 3rd party
        if (!$this->isOpenSourceProjectType()) {
            return \false;
        }
        if ($classMethod->isAbstract()) {
            return \true;
        }
        if (!$class->isAbstract()) {
            return \false;
        }
        return $classMethod->isPublic();
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function shouldSkipOpenSourceEmpty($classMethod) : bool
    {
        // skip as possible contract for 3rd party
        if (!$this->isOpenSourceProjectType()) {
            return \false;
        }
        return $classMethod->stmts === [] || $classMethod->stmts === null;
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function shouldSkipOpenSourceProtectedMethod($classMethod) : bool
    {
        // skip as possible contract for 3rd party
        if (!$this->isOpenSourceProjectType()) {
            return \false;
        }
        if ($classMethod->isPublic()) {
            return \true;
        }
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        if ($classLike->isFinal()) {
            return \false;
        }
        // can be opened
        return $classMethod->isProtected();
    }
}
