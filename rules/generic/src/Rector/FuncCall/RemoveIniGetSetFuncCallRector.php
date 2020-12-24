<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\FuncCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Comment;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Comments\CommentableNodeResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeRemoval\BreakingRemovalGuard;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://twitter.com/afilina & Zenika (CAN) for sponsoring this rule - visit them on https://zenika.ca/en/en
 *
 * @see \Rector\Generic\Tests\Rector\FuncCall\RemoveIniGetSetFuncCallRector\RemoveIniGetSetFuncCallRectorTest
 */
final class RemoveIniGetSetFuncCallRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const KEYS_TO_REMOVE = '$keysToRemove';
    /**
     * @var string[]
     */
    private $keysToRemove = [];
    /**
     * @var BreakingRemovalGuard
     */
    private $breakingRemovalGuard;
    /**
     * @var CommentableNodeResolver
     */
    private $commentableNodeResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeRemoval\BreakingRemovalGuard $breakingRemovalGuard, \_PhpScoper2a4e7ab1ecbc\Rector\Core\Comments\CommentableNodeResolver $commentableNodeResolver)
    {
        $this->breakingRemovalGuard = $breakingRemovalGuard;
        $this->commentableNodeResolver = $commentableNodeResolver;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove ini_get by configuration', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
ini_get('y2k_compliance');
ini_set('y2k_compliance', 1);
CODE_SAMPLE
, '', [self::KEYS_TO_REMOVE => ['y2k_compliance']])]);
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
        if (!$this->isNames($node, ['ini_get', 'ini_set'])) {
            return null;
        }
        if (!isset($node->args[0])) {
            return null;
        }
        $keyValue = $this->getValue($node->args[0]->value);
        if (!\in_array($keyValue, $this->keysToRemove, \true)) {
            return null;
        }
        if ($this->breakingRemovalGuard->isLegalNodeRemoval($node)) {
            $this->removeNode($node);
        } else {
            $commentableNode = $this->commentableNodeResolver->resolve($node);
            $commentableNode->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Comment('// @fixme')]);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->keysToRemove = $configuration[self::KEYS_TO_REMOVE] ?? [];
    }
}
