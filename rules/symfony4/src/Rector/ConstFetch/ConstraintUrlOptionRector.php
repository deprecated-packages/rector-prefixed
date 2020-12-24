<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony4\Rector\ConstFetch;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Ref: https://github.com/symfony/symfony/blob/master/UPGRADE-4.0.md#validator
 * @see \Rector\Symfony4\Tests\Rector\ConstFetch\ConstraintUrlOptionRector\ConstraintUrlOptionRectorTest
 */
final class ConstraintUrlOptionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const URL_CONSTRAINT_CLASS = '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Constraints\\Url';
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns true value to `Url::CHECK_DNS_TYPE_ANY` in Validator in Symfony.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$constraint = new Url(["checkDNS" => true]);', '$constraint = new Url(["checkDNS" => Url::CHECK_DNS_TYPE_ANY]);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch::class];
    }
    /**
     * @param ConstFetch $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isTrue($node)) {
            return null;
        }
        $prevNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if (!$prevNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return null;
        }
        if ($prevNode->value !== 'checkDNS') {
            return null;
        }
        return $this->createClassConstFetch(self::URL_CONSTRAINT_CLASS, 'CHECK_DNS_TYPE_ANY');
    }
}
