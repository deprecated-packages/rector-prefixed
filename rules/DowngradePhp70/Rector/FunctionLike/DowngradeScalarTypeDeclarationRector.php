<?php

declare (strict_types=1);
namespace Rector\DowngradePhp70\Rector\FunctionLike;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use Rector\Core\Rector\AbstractRector;
use Rector\DowngradePhp70\NodeFactory\StringifyIfFactory;
use Rector\DowngradePhp71\TypeDeclaration\PhpDocFromTypeDeclarationDecorator;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://wiki.php.net/rfc/scalar_type_hints
 *
 * @see \Rector\Tests\DowngradePhp70\Rector\FunctionLike\DowngradeScalarTypeDeclarationRector\DowngradeScalarTypeDeclarationRectorTest
 */
final class DowngradeScalarTypeDeclarationRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var PhpDocFromTypeDeclarationDecorator
     */
    private $phpDocFromTypeDeclarationDecorator;
    /**
     * @var StringifyIfFactory
     */
    private $stringifyIfFactory;
    public function __construct(\Rector\DowngradePhp71\TypeDeclaration\PhpDocFromTypeDeclarationDecorator $phpDocFromTypeDeclarationDecorator, \Rector\DowngradePhp70\NodeFactory\StringifyIfFactory $stringifyIfFactory)
    {
        $this->phpDocFromTypeDeclarationDecorator = $phpDocFromTypeDeclarationDecorator;
        $this->stringifyIfFactory = $stringifyIfFactory;
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Function_::class, \PhpParser\Node\Stmt\ClassMethod::class];
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove the type params and return type, add @param and @return tags instead', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(string $input): string
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param string $input
     * @return string
     */
    public function run($input)
    {
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @param Function_|ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($node->params as $param) {
            $this->phpDocFromTypeDeclarationDecorator->decorateParam($param, $node, [\PHPStan\Type\StringType::class, \PHPStan\Type\IntegerType::class, \PHPStan\Type\BooleanType::class, \PHPStan\Type\FloatType::class]);
            $paramType = $this->getStaticType($param);
            if ($paramType instanceof \PHPStan\Type\StringType) {
                $this->decorateWithObjectType($param, $node);
            }
        }
        if (!$this->phpDocFromTypeDeclarationDecorator->decorateReturn($node)) {
            return null;
        }
        return $node;
    }
    /**
     * @param Function_|ClassMethod $functionLike
     * @return Function_|ClassMethod
     */
    private function decorateWithObjectType(\PhpParser\Node\Param $param, \PhpParser\Node\FunctionLike $functionLike) : \PhpParser\Node\FunctionLike
    {
        if ($functionLike->stmts === null) {
            return $functionLike;
        }
        if ($functionLike->stmts === []) {
            return $functionLike;
        }
        // add possible object with __toString() re-type to keep original behavior
        // @see https://twitter.com/VotrubaT/status/1390974218108538887
        /** @var string $variableName */
        $variableName = $this->getName($param->var);
        $if = $this->stringifyIfFactory->createObjetVariableStringCast($variableName);
        $functionLike->stmts = \array_merge([$if], (array) $functionLike->stmts);
        return $functionLike;
    }
}
