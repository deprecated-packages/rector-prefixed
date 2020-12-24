<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Parser;

use _PhpScopere8e811afab72\PhpParser\Lexer;
use _PhpScopere8e811afab72\PhpParser\Parser;
use _PhpScopere8e811afab72\PhpParser\ParserFactory;
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
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Lexer $lexer, \_PhpScopere8e811afab72\PhpParser\ParserFactory $parserFactory)
    {
        $this->lexer = $lexer;
        $this->parserFactory = $parserFactory;
    }
    public function create() : \_PhpScopere8e811afab72\PhpParser\Parser
    {
        return $this->parserFactory->create(\_PhpScopere8e811afab72\PhpParser\ParserFactory::PREFER_PHP7, $this->lexer, ['useIdentifierNodes' => \true, 'useConsistentVariableNodes' => \true, 'useExpressionStatements' => \true, 'useNopStatements' => \false]);
    }
}
