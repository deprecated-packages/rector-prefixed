<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Nette\NodeFactory\CheckRequirementsClassMethodFactory;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/nette/application/commit/a70c7256b645a2bee0b0c2c735020d7043a14558#diff-549e1fc650c1fc7e138900598027656a50d12b031605f8a63a38bd69a3985fafR1324
 */
final class MoveFinalGetUserToCheckRequirementsClassMethodRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var CheckRequirementsClassMethodFactory
     */
    private $checkRequirementsClassMethodFactory;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Nette\NodeFactory\CheckRequirementsClassMethodFactory $checkRequirementsClassMethodFactory, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->checkRequirementsClassMethodFactory = $checkRequirementsClassMethodFactory;
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Presenter method getUser() is now final, move logic to checkRequirements()', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Application\UI\Presenter;

class SomeControl extends Presenter
{
    public function getUser()
    {
        $user = parent::getUser();
        $user->getStorage()->setNamespace('admin_session');
        return $user;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Application\UI\Presenter;

class SomeControl extends Presenter
{
    public function checkRequirements()
    {
        $user = $this->getUser();
        $user->getStorage()->setNamespace('admin_session');

        parent::checkRequirements();
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScoperb75b35f52b74\\Nette\\Application\\UI\\Presenter')) {
            return null;
        }
        $getUserClassMethod = $node->getMethod('getUser');
        if ($getUserClassMethod === null) {
            return null;
        }
        $checkRequirementsClassMethod = $node->getMethod('checkRequirements');
        if ($checkRequirementsClassMethod === null) {
            $checkRequirementsClassMethod = $this->checkRequirementsClassMethodFactory->create((array) $getUserClassMethod->stmts);
            $this->classInsertManipulator->addAsFirstMethod($node, $checkRequirementsClassMethod);
        } else {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException();
        }
        $this->removeNode($getUserClassMethod);
        return $node;
    }
}
