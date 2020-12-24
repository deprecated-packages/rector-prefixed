<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Parser;

use _PhpScoper2a4e7ab1ecbc\PhpParser\ErrorHandler\Collecting;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitor\NameResolver;
use _PhpScoper2a4e7ab1ecbc\PHPStan\File\FileReader;
class SimpleParser implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Parser\Parser
{
    /** @var \PhpParser\Parser */
    private $parser;
    /** @var NameResolver */
    private $nameResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Parser $parser, \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitor\NameResolver $nameResolver)
    {
        $this->parser = $parser;
        $this->nameResolver = $nameResolver;
    }
    /**
     * @param string $file path to a file to parse
     * @return \PhpParser\Node\Stmt[]
     */
    public function parseFile(string $file) : array
    {
        try {
            return $this->parseString(\_PhpScoper2a4e7ab1ecbc\PHPStan\File\FileReader::read($file));
        } catch (\_PhpScoper2a4e7ab1ecbc\PHPStan\Parser\ParserErrorsException $e) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\Parser\ParserErrorsException($e->getErrors(), $file);
        }
    }
    /**
     * @param string $sourceCode
     * @return \PhpParser\Node\Stmt[]
     */
    public function parseString(string $sourceCode) : array
    {
        $errorHandler = new \_PhpScoper2a4e7ab1ecbc\PhpParser\ErrorHandler\Collecting();
        $nodes = $this->parser->parse($sourceCode, $errorHandler);
        if ($errorHandler->hasErrors()) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\Parser\ParserErrorsException($errorHandler->getErrors(), null);
        }
        if ($nodes === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
        }
        $nodeTraverser = new \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->nameResolver);
        /** @var array<\PhpParser\Node\Stmt> */
        return $nodeTraverser->traverse($nodes);
    }
}
