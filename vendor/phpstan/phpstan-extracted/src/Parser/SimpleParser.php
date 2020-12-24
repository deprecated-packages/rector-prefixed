<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Parser;

use _PhpScopere8e811afab72\PhpParser\ErrorHandler\Collecting;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PhpParser\NodeVisitor\NameResolver;
use _PhpScopere8e811afab72\PHPStan\File\FileReader;
class SimpleParser implements \_PhpScopere8e811afab72\PHPStan\Parser\Parser
{
    /** @var \PhpParser\Parser */
    private $parser;
    /** @var NameResolver */
    private $nameResolver;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Parser $parser, \_PhpScopere8e811afab72\PhpParser\NodeVisitor\NameResolver $nameResolver)
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
            return $this->parseString(\_PhpScopere8e811afab72\PHPStan\File\FileReader::read($file));
        } catch (\_PhpScopere8e811afab72\PHPStan\Parser\ParserErrorsException $e) {
            throw new \_PhpScopere8e811afab72\PHPStan\Parser\ParserErrorsException($e->getErrors(), $file);
        }
    }
    /**
     * @param string $sourceCode
     * @return \PhpParser\Node\Stmt[]
     */
    public function parseString(string $sourceCode) : array
    {
        $errorHandler = new \_PhpScopere8e811afab72\PhpParser\ErrorHandler\Collecting();
        $nodes = $this->parser->parse($sourceCode, $errorHandler);
        if ($errorHandler->hasErrors()) {
            throw new \_PhpScopere8e811afab72\PHPStan\Parser\ParserErrorsException($errorHandler->getErrors(), null);
        }
        if ($nodes === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $nodeTraverser = new \_PhpScopere8e811afab72\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->nameResolver);
        /** @var array<\PhpParser\Node\Stmt> */
        return $nodeTraverser->traverse($nodes);
    }
}
