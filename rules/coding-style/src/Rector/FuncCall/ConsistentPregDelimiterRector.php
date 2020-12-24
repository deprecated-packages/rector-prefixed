<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\FuncCall;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\FuncCall\ConsistentPregDelimiterRector\ConsistentPregDelimiterRectorTest
 */
final class ConsistentPregDelimiterRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const DELIMITER = 'delimiter';
    /**
     * @var string
     * @see https://regex101.com/r/isdgEN/1
     *
     * For modifiers see https://www.php.net/manual/en/reference.pcre.pattern.modifiers.php
     */
    private const INNER_REGEX = '#(?<content>.*?)(?<close>[imsxeADSUXJu]*)$#';
    /**
     * All with pattern as 1st argument
     * @var int[]
     */
    private const FUNCTIONS_WITH_REGEX_PATTERN = ['preg_match' => 0, 'preg_replace_callback_array' => 0, 'preg_replace_callback' => 0, 'preg_replace' => 0, 'preg_match_all' => 0, 'preg_split' => 0, 'preg_grep' => 0];
    /**
     * All with pattern as 2st argument
     * @var array<string, array<string, int>>
     */
    private const STATIC_METHODS_WITH_REGEX_PATTERN = ['_PhpScoper0a6b37af0871\\Nette\\Utils\\Strings' => ['match' => 1, 'matchAll' => 1, 'replace' => 1, 'split' => 1]];
    /**
     * @var string
     */
    private $delimiter = '#';
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace PREG delimiter with configured one', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        preg_match('~value~', $value);
        preg_match_all('~value~im', $value);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        preg_match('#value#', $value);
        preg_match_all('#value#im', $value);
    }
}
CODE_SAMPLE
, [self::DELIMITER => '#'])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param FuncCall|StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            return $this->refactorFuncCall($node);
        }
        foreach (self::STATIC_METHODS_WITH_REGEX_PATTERN as $type => $methodsToPositions) {
            if (!$this->isObjectType($node->class, $type)) {
                continue;
            }
            foreach ($methodsToPositions as $method => $position) {
                if (!$this->isName($node->name, $method)) {
                    continue;
                }
                $this->refactorArgument($node->args[$position]);
                return $node;
            }
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->delimiter = $configuration[self::DELIMITER] ?? '#';
    }
    private function refactorFuncCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall
    {
        foreach (self::FUNCTIONS_WITH_REGEX_PATTERN as $function => $position) {
            if (!$this->isName($funcCall, $function)) {
                continue;
            }
            $this->refactorArgument($funcCall->args[$position]);
            return $funcCall;
        }
        return null;
    }
    private function refactorArgument(\_PhpScoper0a6b37af0871\PhpParser\Node\Arg $arg) : void
    {
        if (!$arg->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            return;
        }
        /** @var String_ $string */
        $string = $arg->value;
        $value = $string->value;
        $string->value = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($value, self::INNER_REGEX, function (array $match) : string {
            $innerPattern = $match['content'];
            // change delimiter
            if (\strlen($innerPattern) > 2 && $innerPattern[0] === $innerPattern[\strlen($innerPattern) - 1]) {
                $innerPattern[0] = $this->delimiter;
                $innerPattern[\strlen($innerPattern) - 1] = $this->delimiter;
            }
            return $innerPattern . $match['close'];
        });
    }
}
