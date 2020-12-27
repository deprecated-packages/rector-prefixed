<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\PhpDoc;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\PhpDocParser;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TokenIterator;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node>
 */
class InvalidPHPStanDocTagRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    private const POSSIBLE_PHPSTAN_TAGS = ['@phpstan-param', '@phpstan-var', '@phpstan-template', '@phpstan-extends', '@phpstan-implements', '@phpstan-use', '@phpstan-template', '@phpstan-template-covariant', '@phpstan-return', '@phpstan-throws', '@phpstan-ignore-next-line', '@phpstan-ignore-line', '@phpstan-method'];
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
            if (\strpos($phpDocTag->name, '@phpstan-') !== 0 || \in_array($phpDocTag->name, self::POSSIBLE_PHPSTAN_TAGS, \true)) {
                continue;
            }
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Unknown PHPDoc tag: %s', $phpDocTag->name))->build();
        }
        return $errors;
    }
}
