<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Parser;

use _PhpScoperb75b35f52b74\PhpParser\Lexer;
use _PhpScoperb75b35f52b74\PhpParser\Parser;
use _PhpScoperb75b35f52b74\PhpParser\ParserFactory;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Lexer $lexer, \_PhpScoperb75b35f52b74\PhpParser\ParserFactory $parserFactory)
    {
        $this->lexer = $lexer;
        $this->parserFactory = $parserFactory;
    }
    public function create() : \_PhpScoperb75b35f52b74\PhpParser\Parser
    {
        return $this->parserFactory->create(\_PhpScoperb75b35f52b74\PhpParser\ParserFactory::PREFER_PHP7, $this->lexer, ['useIdentifierNodes' => \true, 'useConsistentVariableNodes' => \true, 'useExpressionStatements' => \true, 'useNopStatements' => \false]);
    }
}
