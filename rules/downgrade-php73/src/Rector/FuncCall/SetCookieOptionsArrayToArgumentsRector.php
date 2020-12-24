<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DowngradePhp73\Rector\FuncCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\BuilderHelpers;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp73\Tests\Rector\FuncCall\SetCookieOptionsArrayToArgumentsRector\SetCookieOptionsArrayToArgumentsRectorTest
 */
final class SetCookieOptionsArrayToArgumentsRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * Conversion table from argument index to options name
     * @var array<string, int>
     */
    private const ARGUMENT_ORDER = ['expires' => 2, 'path' => 3, 'domain' => 4, 'secure' => 5, 'httponly' => 6];
    /**
     * Conversion table from argument index to options name
     * @var array<int, bool|int|string>
     */
    private const ARGUMENT_DEFAULT_VALUES = [2 => 0, 3 => '', 4 => '', 5 => \false, 6 => \false];
    /**
     * @var int
     */
    private $highestIndex = 1;
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert setcookie option array to arguments', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
setcookie('name', $value, ['expires' => 360]);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
setcookie('name', $value, 360);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $node->args = $this->composeNewArgs($node);
        return $node;
    }
    private function shouldSkip(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        if (!$this->isNames($funcCall, ['setcookie', 'setrawcookie'])) {
            return \true;
        }
        $argsCount = \count((array) $funcCall->args);
        if ($argsCount <= 2) {
            return \true;
        }
        return !$funcCall->args[2]->value instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
    }
    /**
     * @return Arg[]
     */
    private function composeNewArgs(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : array
    {
        $this->highestIndex = 1;
        $newArgs = [$funcCall->args[0], $funcCall->args[1]];
        /** @var Array_ $optionsArray */
        $optionsArray = $funcCall->args[2]->value;
        /** @var ArrayItem|null $arrayItem */
        foreach ($optionsArray->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            /** @var Arg $value */
            $value = $arrayItem->value;
            /** @var String_ $key */
            $key = $arrayItem->key;
            $name = $key->value;
            if (!$this->isMappableArrayKey($name)) {
                continue;
            }
            $order = self::ARGUMENT_ORDER[$name];
            if ($order > $this->highestIndex) {
                $this->highestIndex = $order;
            }
            $newArgs[$order] = $value;
        }
        $newArgs = $this->fillMissingArgumentsWithDefaultValues($newArgs);
        \ksort($newArgs);
        return $newArgs;
    }
    private function isMappableArrayKey(string $key) : bool
    {
        return isset(self::ARGUMENT_ORDER[$key]);
    }
    /**
     * @param Arg[] $args
     * @return Arg[]
     */
    private function fillMissingArgumentsWithDefaultValues(array $args) : array
    {
        for ($i = 1; $i < $this->highestIndex; ++$i) {
            if (isset($args[$i])) {
                continue;
            }
            $args[$i] = $this->createDefaultValueArg($i);
        }
        return $args;
    }
    private function createDefaultValueArg(int $argumentIndex) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg
    {
        if (!\array_key_exists($argumentIndex, self::ARGUMENT_DEFAULT_VALUES)) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        $argumentDefaultValue = self::ARGUMENT_DEFAULT_VALUES[$argumentIndex];
        $expr = \_PhpScoper2a4e7ab1ecbc\PhpParser\BuilderHelpers::normalizeValue($argumentDefaultValue);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($expr);
    }
}
