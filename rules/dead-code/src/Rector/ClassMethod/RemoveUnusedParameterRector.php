<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator\MagicMethodDetector;
use _PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator\VariadicFunctionLikeDetector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/function.compact.php
 *
 * @see \Rector\DeadCode\Tests\Rector\ClassMethod\RemoveUnusedParameterRector\RemoveUnusedParameterRectorTest
 * @see \Rector\DeadCode\Tests\Rector\ClassMethod\RemoveUnusedParameterRector\OpenSourceRectorTest
 */
final class RemoveUnusedParameterRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator $classMethodManipulator, \_PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator\MagicMethodDetector $magicMethodDetector, \_PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator\VariadicFunctionLikeDetector $variadicFunctionLikeDetector)
    {
        $this->classManipulator = $classManipulator;
        $this->classMethodManipulator = $classMethodManipulator;
        $this->magicMethodDetector = $magicMethodDetector;
        $this->variadicFunctionLikeDetector = $variadicFunctionLikeDetector;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused parameter, if not required by interface or parent class', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
    private function shouldSkip(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
        $classLike = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        // skip interfaces and traits
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
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
    private function getUnusedParameters(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, string $methodName, array $childrenOfClass) : array
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
        return \array_uintersect($parameters1, $parameters2, function (\_PhpScoper0a6b37af0871\PhpParser\Node\Param $firstParam, \_PhpScoper0a6b37af0871\PhpParser\Node\Param $secondParam) : int {
            return $this->areNodesEqual($firstParam, $secondParam) ? 0 : 1;
        });
    }
    /**
     * @param Param[] $unusedParameters
     */
    private function clearPhpDocInfo(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, array $unusedParameters) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
    private function shouldSkipOpenSourceAbstract(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : bool
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
    private function shouldSkipOpenSourceEmpty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // skip as possible contract for 3rd party
        if (!$this->isOpenSourceProjectType()) {
            return \false;
        }
        return $classMethod->stmts === [] || $classMethod->stmts === null;
    }
    private function shouldSkipOpenSourceProtectedMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // skip as possible contract for 3rd party
        if (!$this->isOpenSourceProjectType()) {
            return \false;
        }
        if ($classMethod->isPublic()) {
            return \true;
        }
        $classLike = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
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
    private function resolveUnusedParameters(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $unusedParameters = [];
        foreach ((array) $classMethod->params as $i => $param) {
            // skip property promotion
            /** @var Param $param */
            if ($param->flags !== 0) {
                continue;
            }
            if ($this->classMethodManipulator->isParameterUsedInClassMethod($param, $classMethod)) {
                // reset to keep order of removed arguments, if not construtctor - probably autowired
                if (!$this->isName($classMethod, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
                    $unusedParameters = [];
                }
                continue;
            }
            $unusedParameters[$i] = $param;
        }
        return $unusedParameters;
    }
}
