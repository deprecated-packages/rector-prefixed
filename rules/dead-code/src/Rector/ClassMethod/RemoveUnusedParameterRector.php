<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\DeadCode\NodeManipulator\MagicMethodDetector;
use Rector\DeadCode\NodeManipulator\VariadicFunctionLikeDetector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/function.compact.php
 *
 * @see \Rector\DeadCode\Tests\Rector\ClassMethod\RemoveUnusedParameterRector\RemoveUnusedParameterRectorTest
 * @see \Rector\DeadCode\Tests\Rector\ClassMethod\RemoveUnusedParameterRector\OpenSourceRectorTest
 */
final class RemoveUnusedParameterRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    /**
     * @var ClassMethodManipulator
     */
    private $classMethodManipulator;
    /**
     * @var MagicMethodDetector
     */
    private $magicMethodDetector;
    /**
     * @var VariadicFunctionLikeDetector
     */
    private $variadicFunctionLikeDetector;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator $classMethodManipulator, \Rector\DeadCode\NodeManipulator\MagicMethodDetector $magicMethodDetector, \Rector\DeadCode\NodeManipulator\VariadicFunctionLikeDetector $variadicFunctionLikeDetector)
    {
        $this->classManipulator = $classManipulator;
        $this->classMethodManipulator = $classMethodManipulator;
        $this->magicMethodDetector = $magicMethodDetector;
        $this->variadicFunctionLikeDetector = $variadicFunctionLikeDetector;
    }
    public function getRuleDefinition() : \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused parameter, if not required by interface or parent class', [new \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        $methodName = $this->getName($node);
        if ($this->classManipulator->hasParentMethodOrInterface($className, $methodName)) {
            return null;
        }
        $childrenOfClass = $this->nodeRepository->findChildrenOfClass($className);
        $unusedParameters = $this->getUnusedParameters($node, $methodName, $childrenOfClass);
        if ($unusedParameters === []) {
            return null;
        }
        foreach ($childrenOfClass as $childClassNode) {
            $methodOfChild = $childClassNode->getMethod($methodName);
            if ($methodOfChild === null) {
                continue;
            }
            $overlappingParameters = $this->getParameterOverlap($methodOfChild->params, $unusedParameters);
            $this->removeNodes($overlappingParameters);
        }
        $this->removeNodes($unusedParameters);
        $this->clearPhpDocInfo($node, $unusedParameters);
        return $node;
    }
    private function shouldSkip(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
        return $this->isAnonymousClass($classLike);
    }
    /**
     * @param Class_[] $childrenOfClass
     * @return Param[]
     */
    private function getUnusedParameters(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $methodName, array $childrenOfClass) : array
    {
        $unusedParameters = $this->resolveUnusedParameters($classMethod);
        if ($unusedParameters === []) {
            return [];
        }
        foreach ($childrenOfClass as $childClassNode) {
            $methodOfChild = $childClassNode->getMethod($methodName);
            if ($methodOfChild === null) {
                continue;
            }
            $unusedParameters = $this->getParameterOverlap($unusedParameters, $this->resolveUnusedParameters($methodOfChild));
        }
        return $unusedParameters;
    }
    /**
     * @param Param[] $parameters1
     * @param Param[] $parameters2
     * @return Param[]
     */
    private function getParameterOverlap(array $parameters1, array $parameters2) : array
    {
        return \array_uintersect($parameters1, $parameters2, function (\PhpParser\Node\Param $firstParam, \PhpParser\Node\Param $secondParam) : int {
            return $this->areNodesEqual($firstParam, $secondParam) ? 0 : 1;
        });
    }
    /**
     * @param Param[] $unusedParameters
     */
    private function clearPhpDocInfo(\PhpParser\Node\Stmt\ClassMethod $classMethod, array $unusedParameters) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        foreach ($unusedParameters as $unusedParameter) {
            $parameterName = $this->getName($unusedParameter->var);
            if ($parameterName === null) {
                continue;
            }
            $paramTagValueNode = $phpDocInfo->getParamTagValueByName($parameterName);
            if ($paramTagValueNode === null) {
                continue;
            }
            if ($paramTagValueNode->parameterName !== '$' . $parameterName) {
                continue;
            }
            $phpDocInfo->removeTagValueNodeFromNode($paramTagValueNode);
        }
    }
    private function shouldSkipOpenSourceAbstract(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Stmt\Class_ $class) : bool
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
    private function shouldSkipOpenSourceEmpty(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // skip as possible contract for 3rd party
        if (!$this->isOpenSourceProjectType()) {
            return \false;
        }
        return $classMethod->stmts === [] || $classMethod->stmts === null;
    }
    private function shouldSkipOpenSourceProtectedMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
    /**
     * @return Param[]
     */
    private function resolveUnusedParameters(\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $unusedParameters = [];
        foreach ($classMethod->params as $i => $param) {
            // skip property promotion
            /** @var Param $param */
            if ($param->flags !== 0) {
                continue;
            }
            if ($this->classMethodManipulator->isParameterUsedInClassMethod($param, $classMethod)) {
                // reset to keep order of removed arguments, if not construtctor - probably autowired
                if (!$this->isName($classMethod, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
                    $unusedParameters = [];
                }
                continue;
            }
            $unusedParameters[$i] = $param;
        }
        return $unusedParameters;
    }
}
