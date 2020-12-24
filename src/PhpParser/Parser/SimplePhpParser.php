<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Parser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitor\NodeConnectingVisitor;
use _PhpScoper0a6b37af0871\PhpParser\Parser;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Parser $parser, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
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
        $nodeTraverser = new \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \_PhpScoper0a6b37af0871\PhpParser\NodeVisitor\NodeConnectingVisitor());
        return $nodeTraverser->traverse($nodes);
    }
}
