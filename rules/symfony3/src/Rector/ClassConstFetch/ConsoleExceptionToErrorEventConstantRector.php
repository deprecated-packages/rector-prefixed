<?php

declare (strict_types=1);
namespace Rector\Symfony3\Rector\ClassConstFetch;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Scalar\String_;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Covers:
 * - https://github.com/symfony/symfony/pull/22441/files
 * - https://github.com/symfony/symfony/blob/master/UPGRADE-3.3.md#console
 *
 * @see \Rector\Symfony3\Tests\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector\ConsoleExceptionToErrorEventConstantRectorTest
 */
final class ConsoleExceptionToErrorEventConstantRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const CONSOLE_EVENTS_CLASS = '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Console\\ConsoleEvents';
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns old event name with EXCEPTION to ERROR constant in Console in Symfony', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('"console.exception"', 'Symfony\\Component\\Console\\ConsoleEvents::ERROR'), new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('Symfony\\Component\\Console\\ConsoleEvents::EXCEPTION', 'Symfony\\Component\\Console\\ConsoleEvents::ERROR')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\ClassConstFetch::class, \PhpParser\Node\Scalar\String_::class];
    }
    /**
     * @param ClassConstFetch|String_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Expr\ClassConstFetch && ($this->isObjectType($node, self::CONSOLE_EVENTS_CLASS) && $this->isName($node->name, 'EXCEPTION'))) {
            return $this->createClassConstFetch(self::CONSOLE_EVENTS_CLASS, 'ERROR');
        }
        if ($node instanceof \PhpParser\Node\Scalar\String_ && $node->value === 'console.exception') {
            return $this->createClassConstFetch(self::CONSOLE_EVENTS_CLASS, 'ERROR');
        }
        return null;
    }
}
