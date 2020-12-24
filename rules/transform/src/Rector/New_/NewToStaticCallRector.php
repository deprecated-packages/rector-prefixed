<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Rector\New_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\NewToStaticCall;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\NewToStaticCallRectorTest
 */
final class NewToStaticCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const TYPE_TO_STATIC_CALLS = 'type_to_static_calls';
    /**
     * @var NewToStaticCall[]
     */
    private $typeToStaticCalls = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change new Object to static call', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        new Cookie($name);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        Cookie::create($name);
    }
}
CODE_SAMPLE
, [self::TYPE_TO_STATIC_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\NewToStaticCall('Cookie', 'Cookie', 'create')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->typeToStaticCalls as $typeToStaticCall) {
            if (!$this->isObjectType($node->class, $typeToStaticCall->getType())) {
                continue;
            }
            return $this->createStaticCall($typeToStaticCall->getStaticCallClass(), $typeToStaticCall->getStaticCallMethod(), $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $typeToStaticCalls = $configuration[self::TYPE_TO_STATIC_CALLS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($typeToStaticCalls, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\NewToStaticCall::class);
        $this->typeToStaticCalls = $typeToStaticCalls;
    }
}
