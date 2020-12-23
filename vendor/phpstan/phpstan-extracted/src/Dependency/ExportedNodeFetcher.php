<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Dependency;

use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\PHPStan\Parser\Parser;
class ExportedNodeFetcher
{
    /** @var Parser */
    private $parser;
    /** @var ExportedNodeVisitor */
    private $visitor;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Parser\Parser $parser, \_PhpScoper0a2ac50786fa\PHPStan\Dependency\ExportedNodeVisitor $visitor)
    {
        $this->parser = $parser;
        $this->visitor = $visitor;
    }
    /**
     * @param string $fileName
     * @return ExportedNode[]
     */
    public function fetchNodes(string $fileName) : array
    {
        $nodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->visitor);
        try {
            /** @var \PhpParser\Node[] $ast */
            $ast = $this->parser->parseFile($fileName);
        } catch (\_PhpScoper0a2ac50786fa\PHPStan\Parser\ParserErrorsException $e) {
            return [];
        }
        $this->visitor->reset($fileName);
        $nodeTraverser->traverse($ast);
        return $this->visitor->getExportedNodes();
    }
}
