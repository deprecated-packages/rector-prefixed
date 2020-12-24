<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/nette/utils/blob/master/src/Utils/Strings.php
 * @see \Rector\Nette\Tests\Rector\FuncCall\SubstrStrlenFunctionToNetteUtilsStringsRector\SubstrStrlenFunctionToNetteUtilsStringsRectorTest
 */
final class SubstrStrlenFunctionToNetteUtilsStringsRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var array<string, string>
     */
    private const FUNCTION_TO_STATIC_METHOD = ['substr' => 'substring'];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use Nette\\Utils\\Strings over bare string-functions', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return substr($value, 0, 3);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return \Nette\Utils\Strings::substring($value, 0, 3);
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach (self::FUNCTION_TO_STATIC_METHOD as $function => $staticMethod) {
            if (!$this->isName($node, $function)) {
                continue;
            }
            return $this->createStaticCall('_PhpScoper0a6b37af0871\\Nette\\Utils\\Strings', $staticMethod, $node->args);
        }
        return null;
    }
}
