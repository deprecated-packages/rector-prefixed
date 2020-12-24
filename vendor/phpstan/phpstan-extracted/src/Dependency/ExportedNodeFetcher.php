<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Dependency;

use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\Parser\Parser;
class ExportedNodeFetcher
{
    /** @var Parser */
    private $parser;
    /** @var ExportedNodeVisitor */
    private $visitor;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Parser\Parser $parser, \_PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNodeVisitor $visitor)
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
        $nodeTraverser = new \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->visitor);
        try {
            /** @var \PhpParser\Node[] $ast */
            $ast = $this->parser->parseFile($fileName);
        } catch (\_PhpScoperb75b35f52b74\PHPStan\Parser\ParserErrorsException $e) {
            return [];
        }
        $this->visitor->reset($fileName);
        $nodeTraverser->traverse($ast);
        return $this->visitor->getExportedNodes();
    }
}
