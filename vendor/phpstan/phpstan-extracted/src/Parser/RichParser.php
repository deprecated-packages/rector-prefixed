<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Parser;

use PhpParser\ErrorHandler\Collecting;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\NodeVisitor\NodeConnectingVisitor;
use RectorPrefix20201227\PHPStan\File\FileReader;
use RectorPrefix20201227\PHPStan\NodeVisitor\StatementOrderVisitor;
class RichParser implements \RectorPrefix20201227\PHPStan\Parser\Parser
{
    /** @var \PhpParser\Parser */
    private $parser;
    /** @var NameResolver */
    private $nameResolver;
    /** @var NodeConnectingVisitor */
    private $nodeConnectingVisitor;
    /** @var StatementOrderVisitor */
    private $statementOrderVisitor;
    public function __construct(\PhpParser\Parser $parser, \PhpParser\NodeVisitor\NameResolver $nameResolver, \PhpParser\NodeVisitor\NodeConnectingVisitor $nodeConnectingVisitor, \RectorPrefix20201227\PHPStan\NodeVisitor\StatementOrderVisitor $statementOrderVisitor)
    {
        $this->parser = $parser;
        $this->nameResolver = $nameResolver;
        $this->nodeConnectingVisitor = $nodeConnectingVisitor;
        $this->statementOrderVisitor = $statementOrderVisitor;
    }
    /**
     * @param string $file path to a file to parse
     * @return \PhpParser\Node\Stmt[]
     */
    public function parseFile(string $file) : array
    {
        try {
            return $this->parseString(\RectorPrefix20201227\PHPStan\File\FileReader::read($file));
        } catch (\RectorPrefix20201227\PHPStan\Parser\ParserErrorsException $e) {
            throw new \RectorPrefix20201227\PHPStan\Parser\ParserErrorsException($e->getErrors(), $file);
        }
    }
    /**
     * @param string $sourceCode
     * @return \PhpParser\Node\Stmt[]
     */
    public function parseString(string $sourceCode) : array
    {
        $errorHandler = new \PhpParser\ErrorHandler\Collecting();
        $nodes = $this->parser->parse($sourceCode, $errorHandler);
        if ($errorHandler->hasErrors()) {
            throw new \RectorPrefix20201227\PHPStan\Parser\ParserErrorsException($errorHandler->getErrors(), null);
        }
        if ($nodes === null) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $nodeTraverser = new \PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->nameResolver);
        $nodeTraverser->addVisitor($this->nodeConnectingVisitor);
        $nodeTraverser->addVisitor($this->statementOrderVisitor);
        /** @var array<\PhpParser\Node\Stmt> */
        return $nodeTraverser->traverse($nodes);
    }
}
