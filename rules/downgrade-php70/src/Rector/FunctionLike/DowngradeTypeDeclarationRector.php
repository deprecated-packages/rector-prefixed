<?php

declare (strict_types=1);
namespace Rector\DowngradePhp70\Rector\FunctionLike;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PHPStan\Type\ArrayType;
use PHPStan\Type\CallableType;
use Rector\Core\Rector\AbstractRector;
use Rector\DowngradePhp71\TypeDeclaration\PhpDocFromTypeDeclarationDecorator;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp70\Tests\Rector\FunctionLike\DowngradeTypeDeclarationRector\DowngradeTypeDeclarationRectorTest
 */
final class DowngradeTypeDeclarationRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var PhpDocFromTypeDeclarationDecorator
     */
    private $phpDocFromTypeDeclarationDecorator;
    public function __construct(\Rector\DowngradePhp71\TypeDeclaration\PhpDocFromTypeDeclarationDecorator $phpDocFromTypeDeclarationDecorator)
    {
        $this->phpDocFromTypeDeclarationDecorator = $phpDocFromTypeDeclarationDecorator;
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
        $this->refactorParams($node);
        $this->phpDocFromTypeDeclarationDecorator->decorateReturn($node);
        return $node;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function refactorParams(\PhpParser\Node\FunctionLike $functionLike) : void
    {
        foreach ($functionLike->params as $param) {
            $this->phpDocFromTypeDeclarationDecorator->decorateParam($param, $functionLike, [\PHPStan\Type\ArrayType::class, \PHPStan\Type\CallableType::class]);
        }
    }
}
