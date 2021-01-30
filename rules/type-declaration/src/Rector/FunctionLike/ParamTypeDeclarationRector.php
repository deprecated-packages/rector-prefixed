<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\FunctionLike;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Interface_;
use PHPStan\Type\MixedType;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\DeadDocBlock\TagRemover\ParamTagRemover;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use Rector\TypeDeclaration\ChildPopulator\ChildParamPopulator;
use Rector\TypeDeclaration\NodeTypeAnalyzer\TraitTypeAnalyzer;
use Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;
use Rector\TypeDeclaration\ValueObject\NewType;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\TypeDeclaration\Tests\Rector\FunctionLike\ParamTypeDeclarationRector\ParamTypeDeclarationRectorTest
 */
final class ParamTypeDeclarationRector extends \Rector\TypeDeclaration\Rector\FunctionLike\AbstractTypeDeclarationRector
{
    /**
     * @var ParamTypeInferer
     */
    private $paramTypeInferer;
    /**
     * @var ChildParamPopulator
     */
    private $childParamPopulator;
    /**
     * @var TraitTypeAnalyzer
     */
    private $traitTypeAnalyzer;
    /**
     * @var ParamTagRemover
     */
    private $paramTagRemover;
    public function __construct(\Rector\TypeDeclaration\ChildPopulator\ChildParamPopulator $childParamPopulator, \Rector\TypeDeclaration\TypeInferer\ParamTypeInferer $paramTypeInferer, \Rector\TypeDeclaration\NodeTypeAnalyzer\TraitTypeAnalyzer $traitTypeAnalyzer, \Rector\DeadDocBlock\TagRemover\ParamTagRemover $paramTagRemover)
    {
        $this->paramTypeInferer = $paramTypeInferer;
        $this->childParamPopulator = $childParamPopulator;
        $this->traitTypeAnalyzer = $traitTypeAnalyzer;
        $this->paramTagRemover = $paramTagRemover;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change @param types to type declarations if not a BC-break', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class ParentClass
{
    /**
     * @param int $number
     */
    public function keep($number)
    {
    }
}

final class ChildClass extends ParentClass
{
    /**
     * @param int $number
     */
    public function keep($number)
    {
    }

    /**
     * @param int $number
     */
    public function change($number)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class ParentClass
{
    /**
     * @param int $number
     */
    public function keep($number)
    {
    }
}

final class ChildClass extends ParentClass
{
    /**
     * @param int $number
     */
    public function keep($number)
    {
    }

    public function change(int $number)
    {
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @param ClassMethod|Function_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return null;
        }
        if ($node->params === []) {
            return null;
        }
        foreach ($node->params as $position => $param) {
            $this->refactorParam($param, $node, (int) $position);
        }
        return null;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function refactorParam(\PhpParser\Node\Param $param, \PhpParser\Node\FunctionLike $functionLike, int $position) : void
    {
        if ($this->shouldSkipParam($param, $functionLike, $position)) {
            return;
        }
        $inferedType = $this->paramTypeInferer->inferParam($param);
        if ($inferedType instanceof \PHPStan\Type\MixedType) {
            return;
        }
        if ($this->traitTypeAnalyzer->isTraitType($inferedType)) {
            return;
        }
        $paramTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($inferedType, \Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper::KIND_PARAM);
        if ($paramTypeNode === null) {
            return;
        }
        $parentNode = $functionLike->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \PhpParser\Node\Stmt\Interface_ && $parentNode->extends !== []) {
            return;
        }
        $param->type = $paramTypeNode;
        $functionLikePhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($functionLike);
        $this->paramTagRemover->removeParamTagsIfUseless($functionLikePhpDocInfo, $functionLike);
        $this->childParamPopulator->populateChildClassMethod($functionLike, $position, $inferedType);
    }
    private function shouldSkipParam(\PhpParser\Node\Param $param, \PhpParser\Node\FunctionLike $functionLike, int $position) : bool
    {
        if ($this->vendorLockResolver->isClassMethodParamLockedIn($functionLike, $position)) {
            return \true;
        }
        if ($param->variadic) {
            return \true;
        }
        // no type → check it
        if ($param->type === null) {
            return \false;
        }
        // already set → skip
        return !$param->type->getAttribute(\Rector\TypeDeclaration\ValueObject\NewType::HAS_NEW_INHERITED_TYPE, \false);
    }
}
