<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Laravel\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Nette\NodeAnalyzer\StaticCallAnalyzer;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://laracasts.com/discuss/channels/laravel/laravel-57-upgrade-observer-problem
 *
 * @see \Rector\Laravel\Tests\Rector\ClassMethod\AddParentBootToModelClassMethodRector\AddParentBootToModelClassMethodRectorTest
 */
final class AddParentBootToModelClassMethodRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const BOOT = 'boot';
    /**
     * @var StaticCallAnalyzer
     */
    private $staticCallAnalyzer;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Nette\NodeAnalyzer\StaticCallAnalyzer $staticCallAnalyzer)
    {
        $this->staticCallAnalyzer = $staticCallAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScoper0a2ac50786fa\\Add parent::boot(); call to boot() class method in child of Illuminate\\Database\\Eloquent\\Model', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function boot()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function boot()
    {
        parent::boot();
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isInObjectType($node, '_PhpScoper0a2ac50786fa\\Illuminate\\Database\\Eloquent\\Model')) {
            return null;
        }
        if (!$this->isName($node->name, self::BOOT)) {
            return null;
        }
        foreach ((array) $node->stmts as $key => $classMethodStmt) {
            if ($classMethodStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
                $classMethodStmt = $classMethodStmt->expr;
            }
            // is in the 1st position? → only correct place
            // @see https://laracasts.com/discuss/channels/laravel/laravel-57-upgrade-observer-problem?page=0#reply=454409
            if (!$this->staticCallAnalyzer->isParentCallNamed($classMethodStmt, self::BOOT)) {
                continue;
            }
            if ($key === 0) {
                return null;
            }
            // wrong location → remove it
            unset($node->stmts[$key]);
        }
        // missing, we need to add one
        $staticCall = $this->nodeFactory->createStaticCall('parent', self::BOOT);
        $parentStaticCallExpression = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($staticCall);
        $node->stmts = \array_merge([$parentStaticCallExpression], (array) $node->stmts);
        return $node;
    }
}
