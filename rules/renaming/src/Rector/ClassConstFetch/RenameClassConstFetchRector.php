<?php

declare (strict_types=1);
namespace Rector\Renaming\Rector\ClassConstFetch;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Renaming\Contract\RenameClassConstFetchInterface;
use Rector\Renaming\ValueObject\RenameClassAndConstFetch;
use Rector\Renaming\ValueObject\RenameClassConstFetch;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210209\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\RenameClassConstFetchRectorTest
 */
final class RenameClassConstFetchRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CLASS_CONSTANT_RENAME = 'constant_rename';
    /**
     * @var RenameClassConstFetchInterface[]
     */
    private $renameClassConstFetches = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $configuration = [self::CLASS_CONSTANT_RENAME => [new \Rector\Renaming\ValueObject\RenameClassConstFetch('SomeClass', 'OLD_CONSTANT', 'NEW_CONSTANT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('SomeClass', 'OTHER_OLD_CONSTANT', 'DifferentClass', 'NEW_CONSTANT')]];
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined class constants in their calls.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$value = SomeClass::OLD_CONSTANT;
$value = SomeClass::OTHER_OLD_CONSTANT;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$value = SomeClass::NEW_CONSTANT;
$value = DifferentClass::NEW_CONSTANT;
CODE_SAMPLE
, $configuration)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\ClassConstFetch::class];
    }
    /**
     * @param ClassConstFetch $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->renameClassConstFetches as $classConstantRename) {
            if (!$this->isObjectType($node, $classConstantRename->getOldClass())) {
                continue;
            }
            if (!$this->isName($node->name, $classConstantRename->getOldConstant())) {
                continue;
            }
            if ($classConstantRename instanceof \Rector\Renaming\ValueObject\RenameClassAndConstFetch) {
                return $this->createClassAndConstFetch($classConstantRename);
            }
            $node->name = new \PhpParser\Node\Identifier($classConstantRename->getNewConstant());
            return $node;
        }
        return $node;
    }
    /**
     * @param array<string, RenameClassConstFetchInterface[]> $configuration
     */
    public function configure(array $configuration) : void
    {
        $renameClassConstFetches = $configuration[self::CLASS_CONSTANT_RENAME] ?? [];
        \RectorPrefix20210209\Webmozart\Assert\Assert::allIsInstanceOf($renameClassConstFetches, \Rector\Renaming\Contract\RenameClassConstFetchInterface::class);
        $this->renameClassConstFetches = $renameClassConstFetches;
    }
    private function createClassAndConstFetch(\Rector\Renaming\ValueObject\RenameClassAndConstFetch $renameClassAndConstFetch) : \PhpParser\Node\Expr\ClassConstFetch
    {
        return new \PhpParser\Node\Expr\ClassConstFetch(new \PhpParser\Node\Name\FullyQualified($renameClassAndConstFetch->getNewClass()), new \PhpParser\Node\Identifier($renameClassAndConstFetch->getNewConstant()));
    }
}
