<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\MagicDisclosure\Rector\String_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MagicDisclosure\Tests\Rector\String_\ToStringToMethodCallRector\ToStringToMethodCallRectorTest
 */
final class ToStringToMethodCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const METHOD_NAMES_BY_TYPE = 'method_names_by_type';
    /**
     * @var string[]
     */
    private $methodNamesByType = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined code uses of "__toString()" method  to specific method calls.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someValue = new SomeObject;
$result = (string) $someValue;
$result = $someValue->__toString();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someValue = new SomeObject;
$result = $someValue->getPath();
$result = $someValue->getPath();
CODE_SAMPLE
, [self::METHOD_NAMES_BY_TYPE => ['SomeObject' => 'getPath']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\String_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param String_|MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\String_) {
            return $this->processStringNode($node);
        }
        return $this->processMethodCall($node);
    }
    public function configure(array $configuration) : void
    {
        $this->methodNamesByType = $configuration[self::METHOD_NAMES_BY_TYPE] ?? [];
    }
    private function processStringNode(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\String_ $string) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->methodNamesByType as $type => $methodName) {
            if (!$this->isObjectType($string, $type)) {
                continue;
            }
            return $this->createMethodCall($string->expr, $methodName);
        }
        return null;
    }
    private function processMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->methodNamesByType as $type => $methodName) {
            if (!$this->isObjectType($methodCall, $type)) {
                continue;
            }
            if (!$this->isName($methodCall->name, '__toString')) {
                continue;
            }
            $methodCall->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($methodName);
            return $methodCall;
        }
        return null;
    }
}
