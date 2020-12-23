<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CakePHP\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Webmozart\Assert\Assert;
/**
 * @see https://book.cakephp.org/3.0/en/appendices/3-4-migration-guide.html#deprecated-combined-get-set-methods
 * @see https://github.com/cakephp/cakephp/commit/326292688c5e6d08945a3cafa4b6ffb33e714eea#diff-e7c0f0d636ca50a0350e9be316d8b0f9
 *
 * @see \Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\ModalToGetSetRectorTest
 */
final class ModalToGetSetRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const UNPREFIXED_METHODS_TO_GET_SET = 'unprefixed_methods_to_get_set';
    /**
     * @var ModalToGetSet[]
     */
    private $unprefixedMethodsToGetSet = [];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes combined set/get `value()` to specific `getValue()` or `setValue(x)`.', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$object = new InstanceConfigTrait;

$config = $object->config();
$config = $object->config('key');

$object->config('key', 'value');
$object->config(['key' => 'value']);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$object = new InstanceConfigTrait;

$config = $object->getConfig();
$config = $object->getConfig('key');

$object->setConfig('key', 'value');
$object->setConfig(['key' => 'value']);
CODE_SAMPLE
, [self::UNPREFIXED_METHODS_TO_GET_SET => [new \_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ModalToGetSet('InstanceConfigTrait', 'config', 'getConfig', 'setConfig')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $unprefixedMethodToGetSet = $this->matchTypeAndMethodName($node);
        if ($unprefixedMethodToGetSet === null) {
            return null;
        }
        $newName = $this->resolveNewMethodNameByCondition($node, $unprefixedMethodToGetSet);
        $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier($newName);
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $unprefixedMethodsToGetSet = $configuration[self::UNPREFIXED_METHODS_TO_GET_SET] ?? [];
        \_PhpScoper0a2ac50786fa\Webmozart\Assert\Assert::allIsInstanceOf($unprefixedMethodsToGetSet, \_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ModalToGetSet::class);
        $this->unprefixedMethodsToGetSet = $unprefixedMethodsToGetSet;
    }
    private function matchTypeAndMethodName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ModalToGetSet
    {
        foreach ($this->unprefixedMethodsToGetSet as $unprefixedMethodToGetSet) {
            if (!$this->isObjectType($methodCall->var, $unprefixedMethodToGetSet->getType())) {
                continue;
            }
            if (!$this->isName($methodCall->name, $unprefixedMethodToGetSet->getUnprefixedMethod())) {
                continue;
            }
            return $unprefixedMethodToGetSet;
        }
        return null;
    }
    private function resolveNewMethodNameByCondition(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ModalToGetSet $modalToGetSet) : string
    {
        if (\count((array) $methodCall->args) >= $modalToGetSet->getMinimalSetterArgumentCount()) {
            return $modalToGetSet->getSetMethod();
        }
        if (!isset($methodCall->args[0])) {
            return $modalToGetSet->getGetMethod();
        }
        // first argument type that is considered setter
        if ($modalToGetSet->getFirstArgumentType() === null) {
            return $modalToGetSet->getGetMethod();
        }
        $firstArgumentType = $modalToGetSet->getFirstArgumentType();
        $argumentValue = $methodCall->args[0]->value;
        if ($firstArgumentType === 'array' && $argumentValue instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_) {
            return $modalToGetSet->getSetMethod();
        }
        return $modalToGetSet->getGetMethod();
    }
}
