<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Symfony3\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Core\Util\StaticRectorStrings;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/blob/3.4/UPGRADE-3.0.md#form
 *
 * @see \Rector\Symfony3\Tests\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector\RemoveDefaultGetBlockPrefixRectorTest
 */
final class RemoveDefaultGetBlockPrefixRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename `getBlockPrefix()` if it returns the default value - class to underscore, e.g. UserFormType = user_form', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Form\AbstractType;

class TaskType extends AbstractType
{
    public function getBlockPrefix()
    {
        return 'task';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Form\AbstractType;

class TaskType extends AbstractType
{
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
        if (!$this->isObjectMethodNameMatch($node)) {
            return null;
        }
        $returnedExpr = $this->resolveOnlyStmtReturnExpr($node);
        if ($returnedExpr === null) {
            return null;
        }
        $returnedValue = $this->getValue($returnedExpr);
        $classShortName = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_SHORT_NAME);
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::endsWith($classShortName, 'Type')) {
            $classShortName = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::before($classShortName, 'Type');
        }
        $underscoredClassShortName = \_PhpScoper0a2ac50786fa\Rector\Core\Util\StaticRectorStrings::camelCaseToUnderscore($classShortName);
        if ($underscoredClassShortName !== $returnedValue) {
            return null;
        }
        $this->removeNode($node);
        return null;
    }
    private function isObjectMethodNameMatch(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isInObjectType($classMethod, '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\AbstractType')) {
            return \false;
        }
        return $this->isName($classMethod->name, 'getBlockPrefix');
    }
    /**
     * return <$thisValue>;
     */
    private function resolveOnlyStmtReturnExpr(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        if (\count((array) $classMethod->stmts) !== 1) {
            return null;
        }
        if (!isset($classMethod->stmts[0])) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        $onlyStmt = $classMethod->stmts[0];
        if (!$onlyStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
            return null;
        }
        return $onlyStmt->expr;
    }
}
