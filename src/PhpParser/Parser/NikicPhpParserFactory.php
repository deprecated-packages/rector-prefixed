<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Parser;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Lexer;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Parser;
use _PhpScoper2a4e7ab1ecbc\PhpParser\ParserFactory;
final class NikicPhpParserFactory
{
    /**
     * @var Lexer
     */
    private $lexer;
    /**
     * @var ParserFactory
     */
    private $parserFactory;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Lexer $lexer, \_PhpScoper2a4e7ab1ecbc\PhpParser\ParserFactory $parserFactory)
    {
        $this->lexer = $lexer;
        $this->parserFactory = $parserFactory;
    }
    public function create() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Parser
    {
        return $this->parserFactory->create(\_PhpScoper2a4e7ab1ecbc\PhpParser\ParserFactory::PREFER_PHP7, $this->lexer, ['useIdentifierNodes' => \true, 'useConsistentVariableNodes' => \true, 'useExpressionStatements' => \true, 'useNopStatements' => \false]);
    }
}
