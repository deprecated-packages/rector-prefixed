<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocRemover;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
use _PhpScopere8e811afab72\Rector\Core\Configuration\CurrentNodeProvider;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
final class PhpDocInfoFactory
{
    /**
     * @var PhpDocParser
     */
    private $betterPhpDocParser;
    /**
     * @var Lexer
     */
    private $lexer;
    /**
     * @var CurrentNodeProvider
     */
    private $currentNodeProvider;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    /**
     * @var PhpDocRemover
     */
    private $phpDocRemover;
    public function __construct(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory, \_PhpScopere8e811afab72\Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer $lexer, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser $betterPhpDocParser, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocRemover $phpDocRemover, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->betterPhpDocParser = $betterPhpDocParser;
        $this->lexer = $lexer;
        $this->currentNodeProvider = $currentNodeProvider;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
        $this->phpDocTypeChanger = $phpDocTypeChanger;
        $this->phpDocRemover = $phpDocRemover;
    }
    public function createFromNodeOrEmpty(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $phpDocInfo = $this->createFromNode($node);
        if ($phpDocInfo !== null) {
            return $phpDocInfo;
        }
        return $this->createEmpty($node);
    }
    public function createFromNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        /** needed for @see PhpDocNodeFactoryInterface */
        $this->currentNodeProvider->setNode($node);
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            if ($node->getComments() !== []) {
                return null;
            }
            // create empty node
            $content = '';
            $tokens = [];
            $phpDocNode = new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode([]);
        } else {
            $content = $docComment->getText();
            $tokens = $this->lexer->tokenize($content);
            $phpDocNode = $this->parseTokensToPhpDocNode($tokens);
            $this->setPositionOfLastToken($phpDocNode);
        }
        return $this->createFromPhpDocNode($phpDocNode, $content, $tokens, $node);
    }
    public function createEmpty(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        /** needed for @see PhpDocNodeFactoryInterface */
        $this->currentNodeProvider->setNode($node);
        $attributeAwarePhpDocNode = new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode([]);
        return $this->createFromPhpDocNode($attributeAwarePhpDocNode, '', [], $node);
    }
    /**
     * @param mixed[][] $tokens
     */
    private function parseTokensToPhpDocNode(array $tokens) : \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode
    {
        $tokenIterator = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
        return $this->betterPhpDocParser->parse($tokenIterator);
    }
    /**
     * Needed for printing
     */
    private function setPositionOfLastToken(\_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode $attributeAwarePhpDocNode) : void
    {
        if ($attributeAwarePhpDocNode->children === []) {
            return;
        }
        $phpDocChildNodes = $attributeAwarePhpDocNode->children;
        /** @var AttributeAwareNodeInterface $lastChildNode */
        $lastChildNode = \array_pop($phpDocChildNodes);
        /** @var StartAndEnd $startAndEnd */
        $startAndEnd = $lastChildNode->getAttribute(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::START_END);
        if ($startAndEnd !== null) {
            $attributeAwarePhpDocNode->setAttribute(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::LAST_TOKEN_POSITION, $startAndEnd->getEnd());
        }
    }
    /**
     * @param mixed[] $tokens
     */
    private function createFromPhpDocNode(\_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode $attributeAwarePhpDocNode, string $content, array $tokens, \_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        /** @var AttributeAwarePhpDocNode $attributeAwarePhpDocNode */
        $attributeAwarePhpDocNode = $this->attributeAwareNodeFactory->createFromNode($attributeAwarePhpDocNode, $content);
        $phpDocInfo = new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo($attributeAwarePhpDocNode, $tokens, $content, $this->staticTypeMapper, $node, $this->phpDocTypeChanger, $this->phpDocRemover, $this->attributeAwareNodeFactory);
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $phpDocInfo);
        return $phpDocInfo;
    }
}
