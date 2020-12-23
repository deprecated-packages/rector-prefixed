<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Lexer;
use _PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Application\PostFileProcessor;
final class NodesWithFileDestinationPrinter
{
    /**
     * @var PostFileProcessor
     */
    private $postFileProcessor;
    /**
     * @var Lexer
     */
    private $lexer;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a2ac50786fa\PhpParser\Lexer $lexer, \_PhpScoper0a2ac50786fa\Rector\PostRector\Application\PostFileProcessor $postFileProcessor)
    {
        $this->postFileProcessor = $postFileProcessor;
        $this->lexer = $lexer;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function printNodesWithFileDestination(\_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\MovedFileWithNodes $movedFileWithNodes) : string
    {
        $nodes = $this->postFileProcessor->traverse($movedFileWithNodes->getNodes());
        $prettyPrintContent = $this->betterStandardPrinter->prettyPrintFile($nodes);
        return $this->resolveLastEmptyLine($prettyPrintContent);
    }
    /**
     * Add empty line in the end, if it is in the original tokens
     */
    private function resolveLastEmptyLine(string $prettyPrintContent) : string
    {
        $tokens = $this->lexer->getTokens();
        $lastToken = \array_pop($tokens);
        if ($lastToken && isset($lastToken[1]) && \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($lastToken[1], "\n")) {
            $prettyPrintContent = \trim($prettyPrintContent) . \PHP_EOL;
        }
        return $prettyPrintContent;
    }
}
