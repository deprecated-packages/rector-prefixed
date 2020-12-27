<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\PhpDoc;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode;
use RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\PhpDocParser;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TokenIterator;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node>
 */
class InvalidPhpDocTagValueRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var Lexer */
    private $phpDocLexer;
    /** @var PhpDocParser */
    private $phpDocParser;
    public function __construct(\RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer, \RectorPrefix20201227\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser)
    {
        $this->phpDocLexer = $phpDocLexer;
        $this->phpDocParser = $phpDocParser;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \PhpParser\Node\Stmt\ClassLike && !$node instanceof \PhpParser\Node\FunctionLike && !$node instanceof \PhpParser\Node\Stmt\Foreach_ && !$node instanceof \PhpParser\Node\Stmt\Property && !$node instanceof \PhpParser\Node\Expr\Assign && !$node instanceof \PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $phpDocString = $docComment->getText();
        $tokens = new \RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TokenIterator($this->phpDocLexer->tokenize($phpDocString));
        $phpDocNode = $this->phpDocParser->parse($tokens);
        $errors = [];
        foreach ($phpDocNode->getTags() as $phpDocTag) {
            if (!$phpDocTag->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode) {
                continue;
            }
            if (\strpos($phpDocTag->name, '@psalm-') === 0) {
                continue;
            }
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag %s has invalid value (%s): %s', $phpDocTag->name, $phpDocTag->value->value, $phpDocTag->value->exception->getMessage()))->build();
        }
        return $errors;
    }
}
