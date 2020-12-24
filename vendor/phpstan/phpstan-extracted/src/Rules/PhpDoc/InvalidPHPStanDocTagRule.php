<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\PhpDoc;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node>
 */
class InvalidPHPStanDocTagRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    private const POSSIBLE_PHPSTAN_TAGS = ['@phpstan-param', '@phpstan-var', '@phpstan-template', '@phpstan-extends', '@phpstan-implements', '@phpstan-use', '@phpstan-template', '@phpstan-template-covariant', '@phpstan-return', '@phpstan-throws', '@phpstan-ignore-next-line', '@phpstan-ignore-line', '@phpstan-method'];
    /** @var Lexer */
    private $phpDocLexer;
    /** @var PhpDocParser */
    private $phpDocParser;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser)
    {
        $this->phpDocLexer = $phpDocLexer;
        $this->phpDocParser = $phpDocParser;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_ && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $phpDocString = $docComment->getText();
        $tokens = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator($this->phpDocLexer->tokenize($phpDocString));
        $phpDocNode = $this->phpDocParser->parse($tokens);
        $errors = [];
        foreach ($phpDocNode->getTags() as $phpDocTag) {
            if (\strpos($phpDocTag->name, '@phpstan-') !== 0 || \in_array($phpDocTag->name, self::POSSIBLE_PHPSTAN_TAGS, \true)) {
                continue;
            }
            $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Unknown PHPDoc tag: %s', $phpDocTag->name))->build();
        }
        return $errors;
    }
}