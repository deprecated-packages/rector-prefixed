<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\PhpDoc;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node>
 */
class InvalidPhpDocTagValueRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var Lexer */
    private $phpDocLexer;
    /** @var PhpDocParser */
    private $phpDocParser;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer, \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser)
    {
        $this->phpDocLexer = $phpDocLexer;
        $this->phpDocParser = $phpDocParser;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_ && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $phpDocString = $docComment->getText();
        $tokens = new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\TokenIterator($this->phpDocLexer->tokenize($phpDocString));
        $phpDocNode = $this->phpDocParser->parse($tokens);
        $errors = [];
        foreach ($phpDocNode->getTags() as $phpDocTag) {
            if (!$phpDocTag->value instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode) {
                continue;
            }
            if (\strpos($phpDocTag->name, '@psalm-') === 0) {
                continue;
            }
            $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag %s has invalid value (%s): %s', $phpDocTag->name, $phpDocTag->value->value, $phpDocTag->value->exception->getMessage()))->build();
        }
        return $errors;
    }
}
