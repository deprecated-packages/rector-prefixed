<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\TypeComparator\TypeComparator;
use Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210408\Webmozart\Assert\Assert;
/**
 * @see \Rector\Tests\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector\AddParamTypeDeclarationRectorTest
 */
final class AddParamTypeDeclarationRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const PARAMETER_TYPEHINTS = 'parameter_typehints';
    /**
     * @var AddParamTypeDeclaration[]
     */
    private $parameterTypehints = [];
    /**
     * @var TypeComparator
     */
    private $typeComparator;
    public function __construct(\Rector\NodeTypeResolver\TypeComparator\TypeComparator $typeComparator)
    {
        $this->typeComparator = $typeComparator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $configuration = [self::PARAMETER_TYPEHINTS => [new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('SomeClass', 'process', 0, new \PHPStan\Type\StringType())]];
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add param types where needed', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
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
        /** @var ClassLike $classLike */
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        foreach ($this->parameterTypehints as $parameterTypehint) {
            if (!$this->isObjectType($classLike, $parameterTypehint->getObjectType())) {
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
        \RectorPrefix20210408\Webmozart\Assert\Assert::allIsInstanceOf($parameterTypehints, \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration::class);
        $this->parameterTypehints = $parameterTypehints;
    }
    private function shouldSkip(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // skip class methods without args
        if ($classMethod->params === []) {
            return \true;
        }
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return \true;
        }
        // skip traits
        if ($classLike instanceof \PhpParser\Node\Stmt\Trait_) {
            return \true;
        }
        // skip class without parents/interfaces
        if ($classLike instanceof \PhpParser\Node\Stmt\Class_) {
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
    private function refactorClassMethodWithTypehintByParameterPosition(\PhpParser\Node\Stmt\ClassMethod $classMethod, \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration $addParamTypeDeclaration) : void
    {
        $parameter = $classMethod->params[$addParamTypeDeclaration->getPosition()] ?? null;
        if (!$parameter instanceof \PhpParser\Node\Param) {
            return;
        }
        $this->refactorParameter($parameter, $addParamTypeDeclaration);
    }
    private function refactorParameter(\PhpParser\Node\Param $param, \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration $addParamTypeDeclaration) : void
    {
        // already set → no change
        if ($param->type !== null) {
            $currentParamType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
            if ($this->typeComparator->areTypesEqual($currentParamType, $addParamTypeDeclaration->getParamType())) {
                return;
            }
        }
        // remove it
        if ($addParamTypeDeclaration->getParamType() instanceof \PHPStan\Type\MixedType) {
            $param->type = null;
            return;
        }
        $returnTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($addParamTypeDeclaration->getParamType());
        $param->type = $returnTypeNode;
    }
}
