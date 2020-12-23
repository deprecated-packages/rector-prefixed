<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Symfony3\Rector\ClassConstFetch;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Covers:
 * - https://github.com/symfony/symfony/pull/22441/files
 * - https://github.com/symfony/symfony/blob/master/UPGRADE-3.3.md#console
 *
 * @see \Rector\Symfony3\Tests\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector\ConsoleExceptionToErrorEventConstantRectorTest
 */
final class ConsoleExceptionToErrorEventConstantRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const CONSOLE_EVENTS_CLASS = '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Console\\ConsoleEvents';
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns old event name with EXCEPTION to ERROR constant in Console in Symfony', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('"console.exception"', 'Symfony\\Component\\Console\\ConsoleEvents::ERROR'), new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('Symfony\\Component\\Console\\ConsoleEvents::EXCEPTION', 'Symfony\\Component\\Console\\ConsoleEvents::ERROR')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_::class];
    }
    /**
     * @param ClassConstFetch|String_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch && ($this->isObjectType($node, self::CONSOLE_EVENTS_CLASS) && $this->isName($node->name, 'EXCEPTION'))) {
            return $this->createClassConstFetch(self::CONSOLE_EVENTS_CLASS, 'ERROR');
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_ && $node->value === 'console.exception') {
            return $this->createClassConstFetch(self::CONSOLE_EVENTS_CLASS, 'ERROR');
        }
        return null;
    }
}
