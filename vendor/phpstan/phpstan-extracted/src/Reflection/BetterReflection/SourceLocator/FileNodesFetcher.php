<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\SourceLocator;

use PhpParser\NodeTraverser;
use PHPStan\File\FileReader;
use PHPStan\Parser\Parser;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
class FileNodesFetcher
{
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\CachingVisitor */
    private $cachingVisitor;
    /** @var Parser */
    private $parser;
    public function __construct(\PHPStan\Reflection\BetterReflection\SourceLocator\CachingVisitor $cachingVisitor, \PHPStan\Parser\Parser $parser)
    {
        $this->cachingVisitor = $cachingVisitor;
        $this->parser = $parser;
    }
    public function fetchNodes(string $fileName) : \PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult
    {
        $nodeTraverser = new \PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->cachingVisitor);
        $contents = \PHPStan\File\FileReader::read($fileName);
        $locatedSource = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource($contents, $fileName);
        try {
            /** @var \PhpParser\Node[] $ast */
            $ast = $this->parser->parseFile($fileName);
        } catch (\PHPStan\Parser\ParserErrorsException $e) {
            return new \PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult([], [], [], $locatedSource);
        }
        $this->cachingVisitor->reset($fileName);
        $nodeTraverser->traverse($ast);
        return new \PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult($this->cachingVisitor->getClassNodes(), $this->cachingVisitor->getFunctionNodes(), $this->cachingVisitor->getConstantNodes(), $locatedSource);
    }
}
