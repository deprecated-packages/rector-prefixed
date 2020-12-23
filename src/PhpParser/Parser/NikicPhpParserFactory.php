<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Parser;

use _PhpScoper0a2ac50786fa\PhpParser\Lexer;
use _PhpScoper0a2ac50786fa\PhpParser\Parser;
use _PhpScoper0a2ac50786fa\PhpParser\ParserFactory;
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
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Lexer $lexer, \_PhpScoper0a2ac50786fa\PhpParser\ParserFactory $parserFactory)
    {
        $this->lexer = $lexer;
        $this->parserFactory = $parserFactory;
    }
    public function create() : \_PhpScoper0a2ac50786fa\PhpParser\Parser
    {
        return $this->parserFactory->create(\_PhpScoper0a2ac50786fa\PhpParser\ParserFactory::PREFER_PHP7, $this->lexer, ['useIdentifierNodes' => \true, 'useConsistentVariableNodes' => \true, 'useExpressionStatements' => \true, 'useNopStatements' => \false]);
    }
}
