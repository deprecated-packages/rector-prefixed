<?php

declare (strict_types=1);
namespace PHPStan\Dependency;

use PhpParser\NodeTraverser;
use PHPStan\Parser\Parser;
class ExportedNodeFetcher
{
    /** @var Parser */
    private $parser;
    /** @var ExportedNodeVisitor */
    private $visitor;
    public function __construct(\PHPStan\Parser\Parser $parser, \PHPStan\Dependency\ExportedNodeVisitor $visitor)
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
        $nodeTraverser = new \PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->visitor);
        try {
            /** @var \PhpParser\Node[] $ast */
            $ast = $this->parser->parseFile($fileName);
        } catch (\PHPStan\Parser\ParserErrorsException $e) {
            return [];
        }
        $this->visitor->reset($fileName);
        $nodeTraverser->traverse($ast);
        return $this->visitor->getExportedNodes();
    }
}
