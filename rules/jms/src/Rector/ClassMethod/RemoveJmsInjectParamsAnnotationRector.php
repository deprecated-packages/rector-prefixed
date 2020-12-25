<?php

declare (strict_types=1);
namespace Rector\JMS\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectParamsTagValueNode;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2864
 *
 * @see \Rector\JMS\Tests\Rector\ClassMethod\RemoveJmsInjectParamsAnnotationRector\RemoveJmsInjectParamsAnnotationRectorTest
 */
final class RemoveJmsInjectParamsAnnotationRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes JMS\\DiExtraBundle\\Annotation\\InjectParams annotation', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use JMS\DiExtraBundle\Annotation as DI;

class SomeClass
{
    /**
     * @DI\InjectParams({
     *     "subscribeService" = @DI\Inject("app.email.service.subscribe"),
     *     "ipService" = @DI\Inject("app.util.service.ip")
     * })
     */
    public function __construct()
    {
    }
}

CODE_SAMPLE
, <<<'CODE_SAMPLE'
use JMS\DiExtraBundle\Annotation as DI;

class SomeClass
{
    public function __construct()
    {
    }
}
CODE_SAMPLE
)]);
    }
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
        if (!$this->isName($node, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $phpDocInfo->removeByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectParamsTagValueNode::class);
        return $node;
    }
}
