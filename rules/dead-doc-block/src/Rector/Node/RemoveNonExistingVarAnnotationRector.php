<?php

declare (strict_types=1);
namespace Rector\DeadDocBlock\Rector\Node;

use RectorPrefix20210109\Nette\Utils\Strings;
use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\AssignRef;
use PhpParser\Node\Stmt\Echo_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Stmt\Static_;
use PhpParser\Node\Stmt\Switch_;
use PhpParser\Node\Stmt\Throw_;
use PhpParser\Node\Stmt\While_;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadDocBlock\Tests\Rector\Node\RemoveNonExistingVarAnnotationRector\RemoveNonExistingVarAnnotationRectorTest
 *
 * @see https://github.com/phpstan/phpstan/commit/d17e459fd9b45129c5deafe12bca56f30ea5ee99#diff-9f3541876405623b0d18631259763dc1
 */
final class RemoveNonExistingVarAnnotationRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var class-string[]
     */
    private const NODES_TO_MATCH = [\PhpParser\Node\Expr\Assign::class, \PhpParser\Node\Expr\AssignRef::class, \PhpParser\Node\Stmt\Foreach_::class, \PhpParser\Node\Stmt\Static_::class, \PhpParser\Node\Stmt\Echo_::class, \PhpParser\Node\Stmt\Return_::class, \PhpParser\Node\Stmt\Expression::class, \PhpParser\Node\Stmt\Throw_::class, \PhpParser\Node\Stmt\If_::class, \PhpParser\Node\Stmt\While_::class, \PhpParser\Node\Stmt\Switch_::class, \PhpParser\Node\Stmt\Nop::class];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes non-existing @var annotations above the code', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function get()
    {
        /** @var Training[] $trainings */
        return $this->getData();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function get()
    {
        return $this->getData();
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
        return [\PhpParser\Node::class];
    }
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $attributeAwareVarTagValueNode = $phpDocInfo->getVarTagValueNode();
        if ($attributeAwareVarTagValueNode === null) {
            return null;
        }
        $variableName = $attributeAwareVarTagValueNode->variableName;
        if ($variableName === '') {
            return null;
        }
        $nodeContentWithoutPhpDoc = $this->printWithoutComments($node);
        // it's there
        if (\RectorPrefix20210109\Nette\Utils\Strings::match($nodeContentWithoutPhpDoc, '#' . \preg_quote($variableName, '#') . '\\b#')) {
            return null;
        }
        $comments = $node->getComments();
        if (isset($comments[1]) && $comments[1] instanceof \PhpParser\Comment) {
            $this->rollbackComments($node, $comments[1]);
            return $node;
        }
        $phpDocInfo->removeByType(\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
        return $node;
    }
    private function shouldSkip(\PhpParser\Node $node) : bool
    {
        if ($node instanceof \PhpParser\Node\Stmt\Nop && \count($node->getComments()) > 1) {
            return \true;
        }
        foreach (self::NODES_TO_MATCH as $nodeToMatch) {
            if (!\is_a($node, $nodeToMatch, \true)) {
                continue;
            }
            return \false;
        }
        return \true;
    }
}
