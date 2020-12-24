<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Dependency;

use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PHPStan\Parser\Parser;
class ExportedNodeFetcher
{
    /** @var Parser */
    private $parser;
    /** @var ExportedNodeVisitor */
    private $visitor;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Parser\Parser $parser, \_PhpScopere8e811afab72\PHPStan\Dependency\ExportedNodeVisitor $visitor)
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
        $nodeTraverser = new \_PhpScopere8e811afab72\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->visitor);
        try {
            /** @var \PhpParser\Node[] $ast */
            $ast = $this->parser->parseFile($fileName);
        } catch (\_PhpScopere8e811afab72\PHPStan\Parser\ParserErrorsException $e) {
            return [];
        }
        $this->visitor->reset($fileName);
        $nodeTraverser->traverse($ast);
        return $this->visitor->getExportedNodes();
    }
}
