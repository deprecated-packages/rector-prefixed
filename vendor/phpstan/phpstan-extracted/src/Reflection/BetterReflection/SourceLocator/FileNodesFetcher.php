<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator;

use PhpParser\NodeTraverser;
use RectorPrefix20201227\PHPStan\File\FileReader;
use RectorPrefix20201227\PHPStan\Parser\Parser;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
class FileNodesFetcher
{
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\CachingVisitor */
    private $cachingVisitor;
    /** @var Parser */
    private $parser;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\CachingVisitor $cachingVisitor, \RectorPrefix20201227\PHPStan\Parser\Parser $parser)
    {
        $this->cachingVisitor = $cachingVisitor;
        $this->parser = $parser;
    }
    public function fetchNodes(string $fileName) : \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult
    {
        $nodeTraverser = new \PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->cachingVisitor);
        $contents = \RectorPrefix20201227\PHPStan\File\FileReader::read($fileName);
        $locatedSource = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Located\LocatedSource($contents, $fileName);
        try {
            /** @var \PhpParser\Node[] $ast */
            $ast = $this->parser->parseFile($fileName);
        } catch (\RectorPrefix20201227\PHPStan\Parser\ParserErrorsException $e) {
            return new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult([], [], [], $locatedSource);
        }
        $this->cachingVisitor->reset($fileName);
        $nodeTraverser->traverse($ast);
        return new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult($this->cachingVisitor->getClassNodes(), $this->cachingVisitor->getFunctionNodes(), $this->cachingVisitor->getConstantNodes(), $locatedSource);
    }
}
