<?php

declare (strict_types=1);
namespace Rector\Core\Application;

use PhpParser\Lexer;
use Rector\ChangesReporting\Collector\AffectedFilesCollector;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\CustomNode\FileNode;
use Rector\Core\PhpParser\NodeTraverser\RectorNodeTraverser;
use Rector\Core\PhpParser\Parser\Parser;
use Rector\Core\PhpParser\Printer\FormatPerservingPrinter;
use Rector\Core\ValueObject\Application\ParsedStmtsAndTokens;
use Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator;
use Rector\PostRector\Application\PostFileProcessor;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
final class FileProcessor
{
    /**
     * @var FormatPerservingPrinter
     */
    private $formatPerservingPrinter;
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var Lexer
     */
    private $lexer;
    /**
     * @var RectorNodeTraverser
     */
    private $rectorNodeTraverser;
    /**
     * @var NodeScopeAndMetadataDecorator
     */
    private $nodeScopeAndMetadataDecorator;
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    /**
     * @var AffectedFilesCollector
     */
    private $affectedFilesCollector;
    /**
     * @var PostFileProcessor
     */
    private $postFileProcessor;
    /**
     * @var TokensByFilePathStorage
     */
    private $tokensByFilePathStorage;
    public function __construct(\Rector\ChangesReporting\Collector\AffectedFilesCollector $affectedFilesCollector, \Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider, \Rector\Core\PhpParser\Printer\FormatPerservingPrinter $formatPerservingPrinter, \PhpParser\Lexer $lexer, \Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator $nodeScopeAndMetadataDecorator, \Rector\Core\PhpParser\Parser\Parser $parser, \Rector\PostRector\Application\PostFileProcessor $postFileProcessor, \Rector\Core\PhpParser\NodeTraverser\RectorNodeTraverser $rectorNodeTraverser, \Rector\Core\Application\TokensByFilePathStorage $tokensByFilePathStorage)
    {
        $this->formatPerservingPrinter = $formatPerservingPrinter;
        $this->parser = $parser;
        $this->lexer = $lexer;
        $this->rectorNodeTraverser = $rectorNodeTraverser;
        $this->nodeScopeAndMetadataDecorator = $nodeScopeAndMetadataDecorator;
        $this->currentFileInfoProvider = $currentFileInfoProvider;
        $this->affectedFilesCollector = $affectedFilesCollector;
        $this->postFileProcessor = $postFileProcessor;
        $this->tokensByFilePathStorage = $tokensByFilePathStorage;
    }
    public function parseFileInfoToLocalCache(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        if ($this->tokensByFilePathStorage->hasForFileInfo($smartFileInfo)) {
            return;
        }
        $this->currentFileInfoProvider->setCurrentFileInfo($smartFileInfo);
        // store tokens by absolute path, so we don't have to print them right now
        $parsedStmtsAndTokens = $this->parseAndTraverseFileInfoToNodes($smartFileInfo);
        $this->tokensByFilePathStorage->addForRealPath($smartFileInfo, $parsedStmtsAndTokens);
    }
    public function printToFile(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $parsedStmtsAndTokens = $this->tokensByFilePathStorage->getForFileInfo($smartFileInfo);
        return $this->formatPerservingPrinter->printParsedStmstAndTokens($smartFileInfo, $parsedStmtsAndTokens);
    }
    /**
     * See https://github.com/nikic/PHP-Parser/issues/344#issuecomment-298162516.
     */
    public function printToString(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $this->makeSureFileIsParsed($smartFileInfo);
        $parsedStmtsAndTokens = $this->tokensByFilePathStorage->getForFileInfo($smartFileInfo);
        return $this->formatPerservingPrinter->printParsedStmstAndTokensToString($parsedStmtsAndTokens);
    }
    public function refactor(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->currentFileInfoProvider->setCurrentFileInfo($smartFileInfo);
        $this->makeSureFileIsParsed($smartFileInfo);
        $parsedStmtsAndTokens = $this->tokensByFilePathStorage->getForFileInfo($smartFileInfo);
        $this->currentFileInfoProvider->setCurrentStmts($parsedStmtsAndTokens->getNewStmts());
        // run file node only if
        $fileNode = new \Rector\Core\PhpParser\Node\CustomNode\FileNode($smartFileInfo, $parsedStmtsAndTokens->getNewStmts());
        $result = $this->rectorNodeTraverser->traverseFileNode($fileNode);
        $newStmts = $this->rectorNodeTraverser->traverse($parsedStmtsAndTokens->getNewStmts());
        // this is needed for new tokens added in "afterTraverse()"
        $parsedStmtsAndTokens->updateNewStmts($newStmts);
        $this->affectedFilesCollector->removeFromList($smartFileInfo);
        while ($otherTouchedFile = $this->affectedFilesCollector->getNext()) {
            $this->refactor($otherTouchedFile);
        }
    }
    public function postFileRefactor(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        if (!$this->tokensByFilePathStorage->hasForFileInfo($smartFileInfo)) {
            $this->parseFileInfoToLocalCache($smartFileInfo);
        }
        $parsedStmtsAndTokens = $this->tokensByFilePathStorage->getForFileInfo($smartFileInfo);
        $this->currentFileInfoProvider->setCurrentStmts($parsedStmtsAndTokens->getNewStmts());
        $this->currentFileInfoProvider->setCurrentFileInfo($smartFileInfo);
        $newStmts = $this->postFileProcessor->traverse($parsedStmtsAndTokens->getNewStmts());
        // this is needed for new tokens added in "afterTraverse()"
        $parsedStmtsAndTokens->updateNewStmts($newStmts);
    }
    private function parseAndTraverseFileInfoToNodes(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \Rector\Core\ValueObject\Application\ParsedStmtsAndTokens
    {
        $oldStmts = $this->parser->parseFileInfo($smartFileInfo);
        $oldTokens = $this->lexer->getTokens();
        // needed for \Rector\NodeTypeResolver\PHPStan\Scope\NodeScopeResolver
        $parsedStmtsAndTokens = new \Rector\Core\ValueObject\Application\ParsedStmtsAndTokens($oldStmts, $oldStmts, $oldTokens);
        $this->tokensByFilePathStorage->addForRealPath($smartFileInfo, $parsedStmtsAndTokens);
        $newStmts = $this->nodeScopeAndMetadataDecorator->decorateNodesFromFile($oldStmts, $smartFileInfo);
        return new \Rector\Core\ValueObject\Application\ParsedStmtsAndTokens($newStmts, $oldStmts, $oldTokens);
    }
    private function makeSureFileIsParsed(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        if ($this->tokensByFilePathStorage->hasForFileInfo($smartFileInfo)) {
            return;
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('File "%s" was not preparsed, so it cannot be printed.%sCheck "%s" method.', $smartFileInfo->getRealPath(), \PHP_EOL, self::class . '::parseFileInfoToLocalCache()'));
    }
}
