<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\JMS\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectParamsTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2864
 *
 * @see \Rector\JMS\Tests\Rector\ClassMethod\RemoveJmsInjectParamsAnnotationRector\RemoveJmsInjectParamsAnnotationRectorTest
 */
final class RemoveJmsInjectParamsAnnotationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes JMS\\DiExtraBundle\\Annotation\\InjectParams annotation', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isName($node, \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $phpDocInfo->removeByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectParamsTagValueNode::class);
        return $node;
    }
}
