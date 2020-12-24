<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\MethodCallRemoverRectorTest
 */
final class MethodCallRemoverRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const METHOD_CALL_REMOVER_ARGUMENT = '$methodCallRemoverArgument';
    /**
     * @var string[]
     */
    private $methodCallRemoverArgument = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns "$this->something()->anything()" to "$this->anything()"', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new Car;
$someObject->something()->anything();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new Car;
$someObject->anything();
CODE_SAMPLE
, [self::METHOD_CALL_REMOVER_ARGUMENT => [self::METHOD_CALL_REMOVER_ARGUMENT => ['Car' => 'something']]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach ($this->methodCallRemoverArgument as $className => $methodName) {
            if (!$this->isObjectType($node->var, $className)) {
                continue;
            }
            if (!$this->isName($node->name, $methodName)) {
                continue;
            }
            return $node->var;
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->methodCallRemoverArgument = $configuration[self::METHOD_CALL_REMOVER_ARGUMENT] ?? [];
    }
}
