<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\PhpDoc;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node>
 */
class InvalidPHPStanDocTagRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    private const POSSIBLE_PHPSTAN_TAGS = ['@phpstan-param', '@phpstan-var', '@phpstan-template', '@phpstan-extends', '@phpstan-implements', '@phpstan-use', '@phpstan-template', '@phpstan-template-covariant', '@phpstan-return', '@phpstan-throws', '@phpstan-ignore-next-line', '@phpstan-ignore-line', '@phpstan-method'];
    /** @var Lexer */
    private $phpDocLexer;
    /** @var PhpDocParser */
    private $phpDocParser;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer, \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser)
    {
        $this->phpDocLexer = $phpDocLexer;
        $this->phpDocParser = $phpDocParser;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_ && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $phpDocString = $docComment->getText();
        $tokens = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TokenIterator($this->phpDocLexer->tokenize($phpDocString));
        $phpDocNode = $this->phpDocParser->parse($tokens);
        $errors = [];
        foreach ($phpDocNode->getTags() as $phpDocTag) {
            if (\strpos($phpDocTag->name, '@phpstan-') !== 0 || \in_array($phpDocTag->name, self::POSSIBLE_PHPSTAN_TAGS, \true)) {
                continue;
            }
            $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Unknown PHPDoc tag: %s', $phpDocTag->name))->build();
        }
        return $errors;
    }
}
