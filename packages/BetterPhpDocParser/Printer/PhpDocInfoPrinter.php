<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Printer;

use RectorPrefix20210408\Nette\Utils\Strings;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\PhpDocNodeVisitor\ChangedPhpDocNodeVisitor;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;
use Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
use RectorPrefix20210408\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
/**
 * @see \Rector\Tests\BetterPhpDocParser\PhpDocInfo\PhpDocInfoPrinter\PhpDocInfoPrinterTest
 */
final class PhpDocInfoPrinter
{
    /**
     * @var string
     * @see https://regex101.com/r/Ab0Vey/1
     */
    public const CLOSING_DOCBLOCK_REGEX = '#\\*\\/(\\s+)?$#';
    /**
     * @var string
     * @see https://regex101.com/r/Jzqzpw/1
     */
    private const MISSING_NEWLINE_REGEX = '#([^\\s])\\*/$#';
    /**
     * @var string
     * @see https://regex101.com/r/mVmOCY/2
     */
    private const OPENING_DOCBLOCK_REGEX = '#^(/\\*\\*)#';
    /**
     * @var string
     * @see https://regex101.com/r/5fJyws/1
     */
    private const CALLABLE_REGEX = '#callable(\\s+)\\(#';
    /**
     * @var string
     * @see https://regex101.com/r/LLWiPl/1
     */
    private const DOCBLOCK_START_REGEX = '#^(\\/\\/|\\/\\*\\*|\\/\\*|\\#)#';
    /**
     * @var string
     */
    private const NEWLINE_WITH_ASTERISK = \PHP_EOL . ' * ';
    /**
     * @see https://regex101.com/r/WR3goY/1/
     * @var string
     */
    private const TAG_AND_SPACE_REGEX = '#(@.*?) \\(#';
    /**
     * @var int
     */
    private $tokenCount;
    /**
     * @var int
     */
    private $currentTokenPosition;
    /**
     * @var mixed[]
     */
    private $tokens = [];
    /**
     * @var PhpDocNode
     */
    private $phpDocNode;
    /**
     * @var PhpDocInfo
     */
    private $phpDocInfo;
    /**
     * @var EmptyPhpDocDetector
     */
    private $emptyPhpDocDetector;
    /**
     * @var DocBlockInliner
     */
    private $docBlockInliner;
    /**
     * @var RemoveNodesStartAndEndResolver
     */
    private $removeNodesStartAndEndResolver;
    /**
     * @var ChangedPhpDocNodeVisitor
     */
    private $changedPhpDocNodeVisitor;
    /**
     * @var PhpDocNodeTraverser
     */
    private $changedPhpDocNodeTraverser;
    public function __construct(\Rector\BetterPhpDocParser\Printer\EmptyPhpDocDetector $emptyPhpDocDetector, \Rector\BetterPhpDocParser\Printer\DocBlockInliner $docBlockInliner, \Rector\BetterPhpDocParser\Printer\RemoveNodesStartAndEndResolver $removeNodesStartAndEndResolver, \Rector\BetterPhpDocParser\PhpDocNodeVisitor\ChangedPhpDocNodeVisitor $changedPhpDocNodeVisitor)
    {
        $this->emptyPhpDocDetector = $emptyPhpDocDetector;
        $this->docBlockInliner = $docBlockInliner;
        $this->removeNodesStartAndEndResolver = $removeNodesStartAndEndResolver;
        $this->changedPhpDocNodeVisitor = $changedPhpDocNodeVisitor;
        $this->changedPhpDocNodeTraverser = new \RectorPrefix20210408\Symplify\SimplePhpDocParser\PhpDocNodeTraverser();
        $this->changedPhpDocNodeTraverser->addPhpDocNodeVisitor($this->changedPhpDocNodeVisitor);
    }
    public function printNew(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : string
    {
        $docContent = (string) $phpDocInfo->getPhpDocNode();
        // fix missing newline in the end of docblock - keep BC compatible for both cases until phpstan with phpdoc-parser 0.5.2 is released
        $docContent = \RectorPrefix20210408\Nette\Utils\Strings::replace($docContent, self::MISSING_NEWLINE_REGEX, "\$1\n */");
        if ($phpDocInfo->isSingleLine()) {
            return $this->docBlockInliner->inline($docContent);
        }
        return $docContent;
    }
    /**
     * As in php-parser
     *
     * ref: https://github.com/nikic/PHP-Parser/issues/487#issuecomment-375986259
     * - Tokens[node.startPos .. subnode1.startPos]
     * - Print(subnode1)
     * - Tokens[subnode1.endPos .. subnode2.startPos]
     * - Print(subnode2)
     * - Tokens[subnode2.endPos .. node.endPos]
     */
    public function printFormatPreserving(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : string
    {
        if ($phpDocInfo->getTokens() === []) {
            // completely new one, just print string version of it
            if ($phpDocInfo->getPhpDocNode()->children === []) {
                return '';
            }
            return (string) $phpDocInfo->getPhpDocNode();
        }
        $this->phpDocNode = $phpDocInfo->getPhpDocNode();
        $this->tokens = $phpDocInfo->getTokens();
        $this->tokenCount = $phpDocInfo->getTokenCount();
        $this->phpDocInfo = $phpDocInfo;
        $this->currentTokenPosition = 0;
        $phpDocString = $this->printPhpDocNode($this->phpDocNode);
        // hotfix of extra space with callable ()
        return \RectorPrefix20210408\Nette\Utils\Strings::replace($phpDocString, self::CALLABLE_REGEX, 'callable(');
    }
    private function printPhpDocNode(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : string
    {
        // no nodes were, so empty doc
        if ($this->emptyPhpDocDetector->isPhpDocNodeEmpty($phpDocNode)) {
            return '';
        }
        $output = '';
        // node output
        $nodeCount = \count($phpDocNode->children);
        foreach ($phpDocNode->children as $key => $phpDocChildNode) {
            $output .= $this->printDocChildNode($phpDocChildNode, $key + 1, $nodeCount);
        }
        $output = $this->printEnd($output);
        // fix missing start
        if (!\RectorPrefix20210408\Nette\Utils\Strings::match($output, self::DOCBLOCK_START_REGEX) && $output) {
            $output = '/**' . $output;
        }
        // fix missing end
        if (\RectorPrefix20210408\Nette\Utils\Strings::match($output, self::OPENING_DOCBLOCK_REGEX) && $output && !\RectorPrefix20210408\Nette\Utils\Strings::match($output, self::CLOSING_DOCBLOCK_REGEX)) {
            $output .= ' */';
        }
        return $output;
    }
    private function printDocChildNode(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode $phpDocChildNode, int $key = 0, int $nodeCount = 0) : string
    {
        $output = '';
        $shouldReprintChildNode = $this->shouldReprint($phpDocChildNode);
        if ($phpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
            if ($shouldReprintChildNode && ($phpDocChildNode->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode || $phpDocChildNode->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode || $phpDocChildNode->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode || $phpDocChildNode->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode || $phpDocChildNode->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode)) {
                // the type has changed → reprint
                $phpDocChildNodeStartEnd = $phpDocChildNode->getAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::START_AND_END);
                // bump the last position of token after just printed node
                if ($phpDocChildNodeStartEnd instanceof \Rector\BetterPhpDocParser\ValueObject\StartAndEnd) {
                    $this->currentTokenPosition = $phpDocChildNodeStartEnd->getEnd();
                }
                return $this->standardPrintPhpDocChildNode($phpDocChildNode);
            }
            if ($phpDocChildNode->value instanceof \Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode && $shouldReprintChildNode) {
                $printedNode = (string) $phpDocChildNode;
                // remove extra space between tags
                $printedNode = \RectorPrefix20210408\Nette\Utils\Strings::replace($printedNode, self::TAG_AND_SPACE_REGEX, '$1(');
                return self::NEWLINE_WITH_ASTERISK . $printedNode;
            }
        }
        /** @var StartAndEnd|null $startAndEnd */
        $startAndEnd = $phpDocChildNode->getAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::START_AND_END);
        if ($startAndEnd instanceof \Rector\BetterPhpDocParser\ValueObject\StartAndEnd && !$shouldReprintChildNode) {
            $isLastToken = $nodeCount === $key;
            // correct previously changed node
            $this->correctPreviouslyReprintedFirstNode($key, $startAndEnd);
            $output = $this->addTokensFromTo($output, $this->currentTokenPosition, $startAndEnd->getEnd(), $isLastToken);
            $this->currentTokenPosition = $startAndEnd->getEnd();
            return \rtrim($output);
        }
        if ($startAndEnd instanceof \Rector\BetterPhpDocParser\ValueObject\StartAndEnd) {
            $this->currentTokenPosition = $startAndEnd->getEnd();
        }
        $standardPrintedPhpDocChildNode = $this->standardPrintPhpDocChildNode($phpDocChildNode);
        return $output . $standardPrintedPhpDocChildNode;
    }
    private function printEnd(string $output) : string
    {
        $lastTokenPosition = $this->phpDocNode->getAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::LAST_PHP_DOC_TOKEN_POSITION) ?: $this->currentTokenPosition;
        if ($lastTokenPosition === 0) {
            $lastTokenPosition = 1;
        }
        return $this->addTokensFromTo($output, $lastTokenPosition, $this->tokenCount, \true);
    }
    private function addTokensFromTo(string $output, int $from, int $to, bool $shouldSkipEmptyLinesAbove) : string
    {
        // skip removed nodes
        $positionJumpSet = [];
        $removedStartAndEnds = $this->removeNodesStartAndEndResolver->resolve($this->phpDocInfo->getOriginalPhpDocNode(), $this->phpDocNode, $this->tokens);
        foreach ($removedStartAndEnds as $removedStartAndEnd) {
            $positionJumpSet[$removedStartAndEnd->getStart()] = $removedStartAndEnd->getEnd();
        }
        // include also space before, in case of inlined docs
        if (isset($this->tokens[$from - 1]) && $this->tokens[$from - 1][1] === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS) {
            --$from;
        }
        // skip extra empty lines above if this is the last one
        if ($shouldSkipEmptyLinesAbove && \RectorPrefix20210408\Nette\Utils\Strings::contains($this->tokens[$from][0], \PHP_EOL) && \RectorPrefix20210408\Nette\Utils\Strings::contains($this->tokens[$from + 1][0], \PHP_EOL)) {
            ++$from;
        }
        return $this->appendToOutput($output, $from, $to, $positionJumpSet);
    }
    /**
     * @param array<int, int> $positionJumpSet
     */
    private function appendToOutput(string $output, int $from, int $to, array $positionJumpSet) : string
    {
        for ($i = $from; $i < $to; ++$i) {
            while (isset($positionJumpSet[$i])) {
                $i = $positionJumpSet[$i];
                continue;
            }
            $output .= $this->tokens[$i][0] ?? '';
        }
        return $output;
    }
    private function correctPreviouslyReprintedFirstNode(int $key, \Rector\BetterPhpDocParser\ValueObject\StartAndEnd $startAndEnd) : void
    {
        if ($this->currentTokenPosition !== 0) {
            return;
        }
        if ($key === 1) {
            return;
        }
        $startTokenPosition = $startAndEnd->getStart();
        $tokens = $this->phpDocInfo->getTokens();
        if (!isset($tokens[$startTokenPosition - 1])) {
            return;
        }
        $previousToken = $tokens[$startTokenPosition - 1];
        if ($previousToken[1] === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) {
            --$startTokenPosition;
        }
        $this->currentTokenPosition = $startTokenPosition;
    }
    private function shouldReprint(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode $phpDocChildNode) : bool
    {
        $this->changedPhpDocNodeTraverser->traverse($phpDocChildNode);
        return $this->changedPhpDocNodeVisitor->hasChanged();
    }
    private function standardPrintPhpDocChildNode(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode $phpDocChildNode) : string
    {
        if ($this->phpDocInfo->isSingleLine()) {
            return ' ' . $phpDocChildNode;
        }
        return self::NEWLINE_WITH_ASTERISK . $phpDocChildNode;
    }
}
