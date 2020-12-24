<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\PhpDoc;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node>
 */
class InvalidPhpDocTagValueRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
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
            if (!$phpDocTag->value instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode) {
                continue;
            }
            if (\strpos($phpDocTag->name, '@psalm-') === 0) {
                continue;
            }
            $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag %s has invalid value (%s): %s', $phpDocTag->name, $phpDocTag->value->value, $phpDocTag->value->exception->getMessage()))->build();
        }
        return $errors;
    }
}
