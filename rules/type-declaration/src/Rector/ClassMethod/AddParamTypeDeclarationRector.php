<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Trait_;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\TypeComparator;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Webmozart\Assert\Assert;
/**
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\AddParamTypeDeclarationRectorTest
 */
final class AddParamTypeDeclarationRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\TypeComparator $typeComparator)
    {
        $this->typeComparator = $typeComparator;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $configuration = [self::PARAMETER_TYPEHINTS => [new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('SomeClass', 'process', 0, new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType())]];
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add param types where needed', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var ClassLike $classLike */
        $classLike = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
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
        \_PhpScoper0a2ac50786fa\Webmozart\Assert\Assert::allIsInstanceOf($parameterTypehints, \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration::class);
        $this->parameterTypehints = $parameterTypehints;
    }
    private function shouldSkip(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // skip class methods without args
        if ((array) $classMethod->params === []) {
            return \true;
        }
        /** @var ClassLike|null $classLike */
        $classLike = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \true;
        }
        // skip traits
        if ($classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Trait_) {
            return \true;
        }
        // skip class without parents/interfaces
        if ($classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
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
    private function refactorClassMethodWithTypehintByParameterPosition(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration $addParamTypeDeclaration) : void
    {
        $parameter = $classMethod->params[$addParamTypeDeclaration->getPosition()] ?? null;
        if ($parameter === null) {
            return;
        }
        $this->refactorParameter($parameter, $addParamTypeDeclaration);
    }
    private function refactorParameter(\_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param, \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration $addParamTypeDeclaration) : void
    {
        // already set → no change
        if ($param->type !== null) {
            $currentParamType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
            if ($this->typeComparator->areTypesEqual($currentParamType, $addParamTypeDeclaration->getParamType())) {
                return;
            }
        }
        // remove it
        if ($addParamTypeDeclaration->getParamType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            $param->type = null;
            return;
        }
        $returnTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($addParamTypeDeclaration->getParamType());
        $param->type = $returnTypeNode;
    }
}
