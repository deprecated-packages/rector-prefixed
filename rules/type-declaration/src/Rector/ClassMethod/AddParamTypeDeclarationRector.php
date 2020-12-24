<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\TypeComparator;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\AddParamTypeDeclarationRectorTest
 */
final class AddParamTypeDeclarationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const PARAMETER_TYPEHINTS = 'parameter_typehintgs';
    /**
     * @var AddParamTypeDeclaration[]
     */
    private $parameterTypehints = [];
    /**
     * @var TypeComparator
     */
    private $typeComparator;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\TypeComparator $typeComparator)
    {
        $this->typeComparator = $typeComparator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $configuration = [self::PARAMETER_TYPEHINTS => [new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('SomeClass', 'process', 0, new \_PhpScopere8e811afab72\PHPStan\Type\StringType())]];
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add param types where needed', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function process($name)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function process(string $name)
    {
    }
}
CODE_SAMPLE
, $configuration)]);
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
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var ClassLike $classLike */
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        foreach ($this->parameterTypehints as $parameterTypehint) {
            if (!$this->isObjectType($classLike, $parameterTypehint->getClassName())) {
                continue;
            }
            if (!$this->isName($node, $parameterTypehint->getMethodName())) {
                continue;
            }
            $this->refactorClassMethodWithTypehintByParameterPosition($node, $parameterTypehint);
        }
        return $node;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $parameterTypehints = $configuration[self::PARAMETER_TYPEHINTS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($parameterTypehints, \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration::class);
        $this->parameterTypehints = $parameterTypehints;
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // skip class methods without args
        if ((array) $classMethod->params === []) {
            return \true;
        }
        /** @var ClassLike|null $classLike */
        $classLike = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \true;
        }
        // skip traits
        if ($classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_) {
            return \true;
        }
        // skip class without parents/interfaces
        if ($classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            if ($classLike->implements !== []) {
                return \false;
            }
            if ($classLike->extends !== null) {
                return \false;
            }
            return \true;
        }
        // skip interface without parents
        /** @var Interface_ $classLike */
        return !(bool) $classLike->extends;
    }
    private function refactorClassMethodWithTypehintByParameterPosition(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration $addParamTypeDeclaration) : void
    {
        $parameter = $classMethod->params[$addParamTypeDeclaration->getPosition()] ?? null;
        if ($parameter === null) {
            return;
        }
        $this->refactorParameter($parameter, $addParamTypeDeclaration);
    }
    private function refactorParameter(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration $addParamTypeDeclaration) : void
    {
        // already set → no change
        if ($param->type !== null) {
            $currentParamType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
            if ($this->typeComparator->areTypesEqual($currentParamType, $addParamTypeDeclaration->getParamType())) {
                return;
            }
        }
        // remove it
        if ($addParamTypeDeclaration->getParamType() instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            $param->type = null;
            return;
        }
        $returnTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($addParamTypeDeclaration->getParamType());
        $param->type = $returnTypeNode;
    }
}
