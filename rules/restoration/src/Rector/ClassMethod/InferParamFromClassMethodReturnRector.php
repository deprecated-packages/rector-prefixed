<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Restoration\Type\ConstantReturnToParamTypeConverter;
use _PhpScopere8e811afab72\Rector\Restoration\ValueObject\InferParamFromClassMethodReturn;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @sponsor Thanks https://github.com/eonx-com for sponsoring this rule
 *
 * @see \Rector\Restoration\Tests\Rector\ClassMethod\InferParamFromClassMethodReturnRector\InferParamFromClassMethodReturnRectorTest
 */
final class InferParamFromClassMethodReturnRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const INFER_PARAMS_FROM_CLASS_METHOD_RETURNS = 'infer_params_from_class_method_returns';
    /**
     * @var InferParamFromClassMethodReturn[]
     */
    private $inferParamFromClassMethodReturn = [];
    /**
     * @var ReturnTypeInferer
     */
    private $returnTypeInferer;
    /**
     * @var ConstantReturnToParamTypeConverter
     */
    private $constantReturnToParamTypeConverter;
    public function __construct(\_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \_PhpScopere8e811afab72\Rector\Restoration\Type\ConstantReturnToParamTypeConverter $constantReturnToParamTypeConverter)
    {
        $this->returnTypeInferer = $returnTypeInferer;
        $this->constantReturnToParamTypeConverter = $constantReturnToParamTypeConverter;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change @param doc based on another method return type', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function getNodeTypes(): array
    {
        return [String_::class];
    }

    public function process(Node $node)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function getNodeTypes(): array
    {
        return [String_::class];
    }

    /**
     * @param String_ $node
     */
    public function process(Node $node)
    {
    }
}
CODE_SAMPLE
, [self::INFER_PARAMS_FROM_CLASS_METHOD_RETURNS => [new \_PhpScopere8e811afab72\Rector\Restoration\ValueObject\InferParamFromClassMethodReturn('SomeClass', 'process', 'getNodeTypes')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        // must be exactly 1 param
        if (\count((array) $node->params) !== 1) {
            return null;
        }
        $firstParam = $node->params[0];
        $paramName = $this->getName($firstParam);
        foreach ($this->inferParamFromClassMethodReturn as $inferParamFromClassMethodReturn) {
            $returnClassMethod = $this->matchReturnClassMethod($node, $inferParamFromClassMethodReturn);
            if ($returnClassMethod === null) {
                continue;
            }
            $returnType = $this->returnTypeInferer->inferFunctionLike($returnClassMethod);
            /** @var PhpDocInfo|null $currentPhpDocInfo */
            $currentPhpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($currentPhpDocInfo === null) {
                $currentPhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
            }
            $paramType = $this->constantReturnToParamTypeConverter->convert($returnType);
            if ($paramType === null) {
                continue;
            }
            if ($this->isParamDocTypeEqualToPhpType($firstParam, $paramType)) {
                return null;
            }
            $currentPhpDocInfo->changeParamType($paramType, $firstParam, $paramName);
            return $node;
        }
        return null;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $inferParamsFromClassMethodReturns = $configuration[self::INFER_PARAMS_FROM_CLASS_METHOD_RETURNS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($inferParamsFromClassMethodReturns, \_PhpScopere8e811afab72\Rector\Restoration\ValueObject\InferParamFromClassMethodReturn::class);
        $this->inferParamFromClassMethodReturn = $inferParamsFromClassMethodReturns;
    }
    private function matchReturnClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\Rector\Restoration\ValueObject\InferParamFromClassMethodReturn $inferParamFromClassMethodReturn) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        if (!$this->isInClassNamed($classMethod, $inferParamFromClassMethodReturn->getClass())) {
            return null;
        }
        if (!$this->isName($classMethod->name, $inferParamFromClassMethodReturn->getParamMethod())) {
            return null;
        }
        $classLike = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        return $classLike->getMethod($inferParamFromClassMethodReturn->getReturnMethod());
    }
    private function isParamDocTypeEqualToPhpType(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PHPStan\Type\Type $paramType) : bool
    {
        $currentParamType = $this->getObjectType($param);
        if ($currentParamType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            $currentParamType = $currentParamType->getTypes()[0];
        }
        return $currentParamType->equals($paramType);
    }
}
