<?php

declare (strict_types=1);
namespace Rector\Utils\DoctrineAnnotationParserSyncer\Rector\ClassMethod;

use _PhpScopera143bcca66cb\Doctrine\Common\Annotations\AnnotationReader;
use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\DoctrineAnnotationGenerated\ConstantPreservingDocParser;
use Rector\Utils\DoctrineAnnotationParserSyncer\Contract\Rector\ClassSyncerRectorInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class ChangeOriginalTypeToCustomRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Utils\DoctrineAnnotationParserSyncer\Contract\Rector\ClassSyncerRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isInClassNamed($node, \_PhpScopera143bcca66cb\Doctrine\Common\Annotations\AnnotationReader::class)) {
            return null;
        }
        if (!$this->isName($node, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return null;
        }
        $firstParam = $node->params[0];
        $firstParam->type = new \PhpParser\Node\Name\FullyQualified(\Rector\DoctrineAnnotationGenerated\ConstantPreservingDocParser::class);
        return $node;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change DocParser type to custom one', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
namespace Doctrine\Common\Annotations;

class AnnotationReader
{
    public function __construct(... $parser)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
namespace Doctrine\Common\Annotations;

class AnnotationReader
{
    public function __construct(\Rector\DoctrineAnnotationGenerated\ConstantPreservingDocParser $parser)
    {
    }
}
CODE_SAMPLE
)]);
    }
}
