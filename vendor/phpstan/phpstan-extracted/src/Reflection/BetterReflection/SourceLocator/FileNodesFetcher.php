<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceLocator;

use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\File\FileReader;
use _PhpScoperb75b35f52b74\PHPStan\Parser\Parser;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
class FileNodesFetcher
{
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\CachingVisitor */
    private $cachingVisitor;
    /** @var Parser */
    private $parser;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceLocator\CachingVisitor $cachingVisitor, \_PhpScoperb75b35f52b74\PHPStan\Parser\Parser $parser)
    {
        $this->cachingVisitor = $cachingVisitor;
        $this->parser = $parser;
    }
    public function fetchNodes(string $fileName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult
    {
        $nodeTraverser = new \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->cachingVisitor);
        $contents = \_PhpScoperb75b35f52b74\PHPStan\File\FileReader::read($fileName);
        $locatedSource = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource($contents, $fileName);
        try {
            /** @var \PhpParser\Node[] $ast */
            $ast = $this->parser->parseFile($fileName);
        } catch (\_PhpScoperb75b35f52b74\PHPStan\Parser\ParserErrorsException $e) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult([], [], [], $locatedSource);
        }
        $this->cachingVisitor->reset($fileName);
        $nodeTraverser->traverse($ast);
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult($this->cachingVisitor->getClassNodes(), $this->cachingVisitor->getFunctionNodes(), $this->cachingVisitor->getConstantNodes(), $locatedSource);
    }
}
