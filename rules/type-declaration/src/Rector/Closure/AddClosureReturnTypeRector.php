<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\Closure;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\TypeDeclaration\Tests\Rector\Closure\AddClosureReturnTypeRector\AddClosureReturnTypeRectorTest
 */
final class AddClosureReturnTypeRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ReturnTypeInferer
     */
    private $returnTypeInferer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer)
    {
        $this->returnTypeInferer = $returnTypeInferer;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add known return type to functions', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($meetups)
    {
        return array_filter($meetups, function (Meetup $meetup) {
            return is_object($meetup);
        });
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($meetups)
    {
        return array_filter($meetups, function (Meetup $meetup): bool {
            return is_object($meetup);
        });
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure::class];
    }
    /**
     * @param Closure $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return null;
        }
        if ($node->returnType !== null) {
            return null;
        }
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        $inferedReturnType = $this->returnTypeInferer->inferFunctionLike($node);
        $returnTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($inferedReturnType);
        if ($returnTypeNode === null) {
            return null;
        }
        $node->returnType = $returnTypeNode;
        return $node;
    }
}
