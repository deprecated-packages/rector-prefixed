<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\SourceLocator;

use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PHPStan\File\FileReader;
use _PhpScoper0a6b37af0871\PHPStan\Parser\Parser;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
class FileNodesFetcher
{
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\CachingVisitor */
    private $cachingVisitor;
    /** @var Parser */
    private $parser;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\SourceLocator\CachingVisitor $cachingVisitor, \_PhpScoper0a6b37af0871\PHPStan\Parser\Parser $parser)
    {
        $this->cachingVisitor = $cachingVisitor;
        $this->parser = $parser;
    }
    public function fetchNodes(string $fileName) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult
    {
        $nodeTraverser = new \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->cachingVisitor);
        $contents = \_PhpScoper0a6b37af0871\PHPStan\File\FileReader::read($fileName);
        $locatedSource = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource($contents, $fileName);
        try {
            /** @var \PhpParser\Node[] $ast */
            $ast = $this->parser->parseFile($fileName);
        } catch (\_PhpScoper0a6b37af0871\PHPStan\Parser\ParserErrorsException $e) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult([], [], [], $locatedSource);
        }
        $this->cachingVisitor->reset($fileName);
        $nodeTraverser->traverse($ast);
        return new \_PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult($this->cachingVisitor->getClassNodes(), $this->cachingVisitor->getFunctionNodes(), $this->cachingVisitor->getConstantNodes(), $locatedSource);
    }
}
