<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Parser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PhpParser\NodeVisitor\NodeConnectingVisitor;
use _PhpScopere8e811afab72\PhpParser\Parser;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class SimplePhpParser
{
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Parser $parser, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->parser = $parser;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return Node[]
     */
    public function parseFile(string $filePath) : array
    {
        $fileContent = $this->smartFileSystem->readFile($filePath);
        $nodes = $this->parser->parse($fileContent);
        if ($nodes === null) {
            return [];
        }
        $nodeTraverser = new \_PhpScopere8e811afab72\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \_PhpScopere8e811afab72\PhpParser\NodeVisitor\NodeConnectingVisitor());
        return $nodeTraverser->traverse($nodes);
    }
}
