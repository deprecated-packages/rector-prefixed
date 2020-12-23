<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Parser;

use _PhpScoper0a2ac50786fa\PhpParser\ErrorHandler\Collecting;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NameResolver;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NodeConnectingVisitor;
use _PhpScoper0a2ac50786fa\PHPStan\File\FileReader;
use _PhpScoper0a2ac50786fa\PHPStan\NodeVisitor\StatementOrderVisitor;
class RichParser implements \_PhpScoper0a2ac50786fa\PHPStan\Parser\Parser
{
    /** @var \PhpParser\Parser */
    private $parser;
    /** @var NameResolver */
    private $nameResolver;
    /** @var NodeConnectingVisitor */
    private $nodeConnectingVisitor;
    /** @var StatementOrderVisitor */
    private $statementOrderVisitor;
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Parser $parser, \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NameResolver $nameResolver, \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NodeConnectingVisitor $nodeConnectingVisitor, \_PhpScoper0a2ac50786fa\PHPStan\NodeVisitor\StatementOrderVisitor $statementOrderVisitor)
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
            return $this->parseString(\_PhpScoper0a2ac50786fa\PHPStan\File\FileReader::read($file));
        } catch (\_PhpScoper0a2ac50786fa\PHPStan\Parser\ParserErrorsException $e) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\Parser\ParserErrorsException($e->getErrors(), $file);
        }
    }
    /**
     * @param string $sourceCode
     * @return \PhpParser\Node\Stmt[]
     */
    public function parseString(string $sourceCode) : array
    {
        $errorHandler = new \_PhpScoper0a2ac50786fa\PhpParser\ErrorHandler\Collecting();
        $nodes = $this->parser->parse($sourceCode, $errorHandler);
        if ($errorHandler->hasErrors()) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\Parser\ParserErrorsException($errorHandler->getErrors(), null);
        }
        if ($nodes === null) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        $nodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->nameResolver);
        $nodeTraverser->addVisitor($this->nodeConnectingVisitor);
        $nodeTraverser->addVisitor($this->statementOrderVisitor);
        /** @var array<\PhpParser\Node\Stmt> */
        return $nodeTraverser->traverse($nodes);
    }
}
