<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Laravel\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Nette\NodeAnalyzer\StaticCallAnalyzer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://laracasts.com/discuss/channels/laravel/laravel-57-upgrade-observer-problem
 *
 * @see \Rector\Laravel\Tests\Rector\ClassMethod\AddParentBootToModelClassMethodRector\AddParentBootToModelClassMethodRectorTest
 */
final class AddParentBootToModelClassMethodRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const BOOT = 'boot';
    /**
     * @var StaticCallAnalyzer
     */
    private $staticCallAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\Nette\NodeAnalyzer\StaticCallAnalyzer $staticCallAnalyzer)
    {
        $this->staticCallAnalyzer = $staticCallAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScopere8e811afab72\\Add parent::boot(); call to boot() class method in child of Illuminate\\Database\\Eloquent\\Model', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isInObjectType($node, '_PhpScopere8e811afab72\\Illuminate\\Database\\Eloquent\\Model')) {
            return null;
        }
        if (!$this->isName($node->name, self::BOOT)) {
            return null;
        }
        foreach ((array) $node->stmts as $key => $classMethodStmt) {
            if ($classMethodStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
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
        $parentStaticCallExpression = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($staticCall);
        $node->stmts = \array_merge([$parentStaticCallExpression], (array) $node->stmts);
        return $node;
    }
}
