<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Parser;

use _PhpScoper0a6b37af0871\PhpParser\Lexer;
use _PhpScoper0a6b37af0871\PhpParser\Parser;
use _PhpScoper0a6b37af0871\PhpParser\ParserFactory;
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
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Lexer $lexer, \_PhpScoper0a6b37af0871\PhpParser\ParserFactory $parserFactory)
    {
        $this->lexer = $lexer;
        $this->parserFactory = $parserFactory;
    }
    public function create() : \_PhpScoper0a6b37af0871\PhpParser\Parser
    {
        return $this->parserFactory->create(\_PhpScoper0a6b37af0871\PhpParser\ParserFactory::PREFER_PHP7, $this->lexer, ['useIdentifierNodes' => \true, 'useConsistentVariableNodes' => \true, 'useExpressionStatements' => \true, 'useNopStatements' => \false]);
    }
}
