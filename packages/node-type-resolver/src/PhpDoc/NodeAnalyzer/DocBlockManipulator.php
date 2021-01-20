<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer;

use RectorPrefix20210120\Nette\Utils\Strings;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class DocBlockManipulator
{
    /**
     * @var string
     * @see https://regex101.com/r/VdaVGL/1
     */
    public const SPACE_OR_ASTERISK_REGEX = '#(\\s|\\*)+#';
    /**
     * @var string
     * @see https://regex101.com/r/Mjb0qi/1
     */
    private const NEWLINE_CLOSING_DOC_REGEX = "#\n \\*\\/\$#";
    /**
     * @var string
     * @see https://regex101.com/r/U5OUV4/2
     */
    private const NEWLINE_MIDDLE_DOC_REGEX = "#\n \\* #";
    /**
     * @var PhpDocInfoPrinter
     */
    private $phpDocInfoPrinter;
    /**
     * @var DocBlockClassRenamer
     */
    private $docBlockClassRenamer;
    public function __construct(\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer $docBlockClassRenamer, \Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter $phpDocInfoPrinter)
    {
        $this->phpDocInfoPrinter = $phpDocInfoPrinter;
        $this->docBlockClassRenamer = $docBlockClassRenamer;
    }
    public function changeType(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \PhpParser\Node $node, \PHPStan\Type\Type $oldType, \PHPStan\Type\Type $newType) : void
    {
        $this->docBlockClassRenamer->renamePhpDocType($phpDocInfo, $oldType, $newType, $node);
    }
    public function updateNodeWithPhpDocInfo(\PhpParser\Node $node) : void
    {
        // nothing to change
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        $phpDoc = $this->printPhpDocInfoToString($phpDocInfo);
        // make sure, that many separated comments are not removed
        if ($phpDoc === '' && \count($node->getComments()) > 1) {
            foreach ($node->getComments() as $comment) {
                $phpDoc .= $comment->getText() . \PHP_EOL;
            }
        }
        if ($phpDoc === '') {
            if ($phpDocInfo->getOriginalPhpDocNode()->children !== []) {
                // all comments were removed → null
                $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, null);
            }
            return;
        }
        // no change, don't save it
        // this is needed to prevent short classes override with FQN with same value → people don't like that for some reason
        if (!$this->haveDocCommentOrCommentsChanged($node, $phpDoc)) {
            return;
        }
        // this is needed to remove duplicated // commentsAsText
        $node->setDocComment(new \PhpParser\Comment\Doc($phpDoc));
    }
    private function printPhpDocInfoToString(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : string
    {
        // new node, needs to be reparsed
        if ($phpDocInfo->isNewNode()) {
            $docContent = (string) $phpDocInfo->getPhpDocNode();
            if (!$phpDocInfo->isSingleLine()) {
                return $docContent;
            }
            return $this->inlineDocContent($docContent);
        }
        return $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo);
    }
    private function haveDocCommentOrCommentsChanged(\PhpParser\Node $node, string $phpDoc) : bool
    {
        $docComment = $node->getDocComment();
        if ($docComment !== null && $docComment->getText() === $phpDoc) {
            return \false;
        }
        $phpDoc = $this->completeSimpleCommentsToPhpDoc($node, $phpDoc);
        if ($node->getComments() !== []) {
            $commentsContent = \implode(\PHP_EOL, $node->getComments());
            if ($this->removeSpacesAndAsterisks($commentsContent) === $this->removeSpacesAndAsterisks($phpDoc)) {
                return \false;
            }
        }
        return \true;
    }
    private function inlineDocContent(string $docContent) : string
    {
        $docContent = \RectorPrefix20210120\Nette\Utils\Strings::replace($docContent, self::NEWLINE_MIDDLE_DOC_REGEX, ' ');
        return \RectorPrefix20210120\Nette\Utils\Strings::replace($docContent, self::NEWLINE_CLOSING_DOC_REGEX, ' */');
    }
    /**
     * add // comments to phpdoc (only has /**
     */
    private function completeSimpleCommentsToPhpDoc(\PhpParser\Node $node, string $phpDoc) : string
    {
        $startComments = '';
        foreach ($node->getComments() as $comment) {
            // skip simple comments
            if (\RectorPrefix20210120\Nette\Utils\Strings::startsWith($comment->getText(), '//')) {
                continue;
            }
            if (\RectorPrefix20210120\Nette\Utils\Strings::startsWith($comment->getText(), '#')) {
                continue;
            }
            $startComments .= $comment->getText() . \PHP_EOL;
        }
        if ($startComments === '') {
            return $phpDoc;
        }
        return $startComments . \PHP_EOL . $phpDoc;
    }
    private function removeSpacesAndAsterisks(string $content) : string
    {
        return \RectorPrefix20210120\Nette\Utils\Strings::replace($content, self::SPACE_OR_ASTERISK_REGEX, '');
    }
}
