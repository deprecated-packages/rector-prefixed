<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStan\Rector\Assign;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Comment\Doc;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/shopsys/shopsys/pull/524
 * @see \Rector\PHPStan\Tests\Rector\Assign\PHPStormVarAnnotationRector\PHPStormVarAnnotationRectorTest
 */
final class PHPStormVarAnnotationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/YY5stJ/1
     */
    private const SINGLE_ASTERISK_COMMENT_START_REGEX = '#^\\/\\* #';
    /**
     * @var string
     * @see https://regex101.com/r/meD7rP/1
     */
    private const VAR_ANNOTATION_REGEX = '#\\@var(\\s)+\\$#';
    /**
     * @var string
     * @see https://regex101.com/r/yz2AZ7/1
     */
    private const VARIABLE_NAME_AND_TYPE_MATCH_REGEX = '#(?<variableName>\\$\\w+)(?<space>\\s+)(?<type>[\\\\\\w]+)#';
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change various @var annotation formats to one PHPStorm understands', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$config = 5;
/** @var \Shopsys\FrameworkBundle\Model\Product\Filter\ProductFilterConfig $config */
CODE_SAMPLE
, <<<'CODE_SAMPLE'
/** @var \Shopsys\FrameworkBundle\Model\Product\Filter\ProductFilterConfig $config */
$config = 5;
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        /** @var Expression|null $expression */
        $expression = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        // unable to analyze
        if ($expression === null) {
            return null;
        }
        /** @var Node|null $nextNode */
        $nextNode = $expression->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if ($nextNode === null) {
            return null;
        }
        $docContent = $this->getDocContent($nextNode);
        if ($docContent === '') {
            return null;
        }
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($docContent, '@var')) {
            return null;
        }
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return null;
        }
        $varName = '$' . $this->getName($node->var);
        $varPattern = '# ' . \preg_quote($varName, '#') . ' #';
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::match($docContent, $varPattern)) {
            return null;
        }
        // switch docs
        $expression->setDocComment($this->createDocComment($nextNode));
        $expressionPhpDocInfo = $this->phpDocInfoFactory->createFromNode($expression);
        $expression->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $expressionPhpDocInfo);
        // invoke override
        $expression->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        // remove otherwise empty node
        if ($nextNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop) {
            $this->removeNode($nextNode);
            return null;
        }
        // remove commnets
        $nextNode->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, null);
        $nextNode->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, null);
        return $node;
    }
    private function getDocContent(\_PhpScopere8e811afab72\PhpParser\Node $node) : string
    {
        $docComment = $node->getDocComment();
        if ($docComment !== null) {
            return $docComment->getText();
        }
        if ($node->getComments() !== []) {
            $docContent = '';
            foreach ($node->getComments() as $comment) {
                $docContent .= $comment->getText();
            }
            return $docContent;
        }
        return '';
    }
    private function createDocComment(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PhpParser\Comment\Doc
    {
        if ($node->getDocComment() !== null) {
            return $node->getDocComment();
        }
        $docContent = $this->getDocContent($node);
        // normalize content
        // starts with "/*", instead of "/**"
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::startsWith($docContent, '/* ')) {
            $docContent = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($docContent, self::SINGLE_ASTERISK_COMMENT_START_REGEX, '/** ');
        }
        // $value is first, instead of type is first
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::match($docContent, self::VAR_ANNOTATION_REGEX)) {
            $docContent = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($docContent, self::VARIABLE_NAME_AND_TYPE_MATCH_REGEX, '$3$2$1');
        }
        return new \_PhpScopere8e811afab72\PhpParser\Comment\Doc($docContent);
    }
}
