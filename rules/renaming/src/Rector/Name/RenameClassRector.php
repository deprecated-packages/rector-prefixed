<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\RenamedClassesDataCollector;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\NodeManipulator\ClassRenamer;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Renaming\Tests\Rector\Name\RenameClassRector\RenameClassRectorTest
 */
final class RenameClassRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const OLD_TO_NEW_CLASSES = 'old_to_new_classes';
    /**
     * @var string[]
     */
    private $oldToNewClasses = [];
    /**
     * @var ClassRenamer
     */
    private $classRenamer;
    /**
     * @var RenamedClassesDataCollector
     */
    private $renamedClassesDataCollector;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\RenamedClassesDataCollector $renamedClassesDataCollector, \_PhpScoperb75b35f52b74\Rector\Renaming\NodeManipulator\ClassRenamer $classRenamer)
    {
        $this->classRenamer = $classRenamer;
        $this->renamedClassesDataCollector = $renamedClassesDataCollector;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined classes by new ones.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
namespace App;

use SomeOldClass;

function someFunction(SomeOldClass $someOldClass): SomeOldClass
{
    if ($someOldClass instanceof SomeOldClass) {
        return new SomeOldClass;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
namespace App;

use SomeNewClass;

function someFunction(SomeNewClass $someOldClass): SomeNewClass
{
    if ($someOldClass instanceof SomeNewClass) {
        return new SomeNewClass;
    }
}
CODE_SAMPLE
, [self::OLD_TO_NEW_CLASSES => ['_PhpScoperb75b35f52b74\\App\\SomeOldClass' => '_PhpScoperb75b35f52b74\\App\\SomeNewClass']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Name::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property::class, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_::class, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace::class];
    }
    /**
     * @param FunctionLike|Name|ClassLike|Expression|Namespace_|Property|FileWithoutNamespace $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->classRenamer->renameNode($node, $this->oldToNewClasses);
    }
    public function configure(array $configuration) : void
    {
        $this->oldToNewClasses = $configuration[self::OLD_TO_NEW_CLASSES] ?? [];
        if ($this->oldToNewClasses !== []) {
            $this->renamedClassesDataCollector->setOldToNewClasses($this->oldToNewClasses);
        }
    }
}
