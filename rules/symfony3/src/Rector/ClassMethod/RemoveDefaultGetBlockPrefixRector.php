<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/blob/3.4/UPGRADE-3.0.md#form
 *
 * @see \Rector\Symfony3\Tests\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector\RemoveDefaultGetBlockPrefixRectorTest
 */
final class RemoveDefaultGetBlockPrefixRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename `getBlockPrefix()` if it returns the default value - class to underscore, e.g. UserFormType = user_form', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isObjectMethodNameMatch($node)) {
            return null;
        }
        $returnedExpr = $this->resolveOnlyStmtReturnExpr($node);
        if ($returnedExpr === null) {
            return null;
        }
        $returnedValue = $this->getValue($returnedExpr);
        $classShortName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_SHORT_NAME);
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($classShortName, 'Type')) {
            $classShortName = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::before($classShortName, 'Type');
        }
        $underscoredClassShortName = \_PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings::camelCaseToUnderscore($classShortName);
        if ($underscoredClassShortName !== $returnedValue) {
            return null;
        }
        $this->removeNode($node);
        return null;
    }
    private function isObjectMethodNameMatch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isInObjectType($classMethod, '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\AbstractType')) {
            return \false;
        }
        return $this->isName($classMethod->name, 'getBlockPrefix');
    }
    /**
     * return <$thisValue>;
     */
    private function resolveOnlyStmtReturnExpr(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if (\count((array) $classMethod->stmts) !== 1) {
            return null;
        }
        if (!isset($classMethod->stmts[0])) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $onlyStmt = $classMethod->stmts[0];
        if (!$onlyStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            return null;
        }
        return $onlyStmt->expr;
    }
}
