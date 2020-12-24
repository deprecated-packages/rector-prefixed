<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\RenamedClassesDataCollector;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\NodeManipulator\ClassRenamer;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Renaming\Tests\Rector\Name\RenameClassRector\RenameClassRectorTest
 */
final class RenameClassRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\RenamedClassesDataCollector $renamedClassesDataCollector, \_PhpScoper0a6b37af0871\Rector\Renaming\NodeManipulator\ClassRenamer $classRenamer)
    {
        $this->classRenamer = $classRenamer;
        $this->renamedClassesDataCollector = $renamedClassesDataCollector;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined classes by new ones.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::OLD_TO_NEW_CLASSES => ['_PhpScoper0a6b37af0871\\App\\SomeOldClass' => '_PhpScoper0a6b37af0871\\App\\SomeNewClass']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Name::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property::class, \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_::class, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace::class];
    }
    /**
     * @param FunctionLike|Name|ClassLike|Expression|Namespace_|Property|FileWithoutNamespace $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
