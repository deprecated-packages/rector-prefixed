<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPStan\Rector\Node;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Echo_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Static_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Switch_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Throw_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\While_;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPStan\Tests\Rector\Node\RemoveNonExistingVarAnnotationRector\RemoveNonExistingVarAnnotationRectorTest
 *
 * @see https://github.com/phpstan/phpstan/commit/d17e459fd9b45129c5deafe12bca56f30ea5ee99#diff-9f3541876405623b0d18631259763dc1
 */
final class RemoveNonExistingVarAnnotationRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var class-string[]
     */
    private const NODES_TO_MATCH = [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Static_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Echo_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Throw_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\While_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Switch_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop::class];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes non-existing @var annotations above the code', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node::class];
    }
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($nodeContentWithoutPhpDoc, '#' . \preg_quote($variableName, '#') . '\\b#')) {
            return null;
        }
        $phpDocInfo->removeByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
        return $node;
    }
    private function shouldSkip(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop && \count($node->getComments()) > 1) {
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
