<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassConstFetch;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\RenameClassConstantRectorTest
 */
final class RenameClassConstantRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CLASS_CONSTANT_RENAME = 'constant_rename';
    /**
     * @var RenameClassConstant[]
     */
    private $classConstantRenames = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $configuration = [self::CLASS_CONSTANT_RENAME => [new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant('SomeClass', 'OLD_CONSTANT', 'NEW_CONSTANT'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant('SomeClass', 'OTHER_OLD_CONSTANT', 'DifferentClass::NEW_CONSTANT')]];
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined class constants in their calls.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch::class];
    }
    /**
     * @param ClassConstFetch $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($this->classConstantRenames as $classConstantRename) {
            if (!$this->isObjectType($node, $classConstantRename->getOldClass())) {
                continue;
            }
            if (!$this->isName($node->name, $classConstantRename->getOldConstant())) {
                continue;
            }
            if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($classConstantRename->getNewConstant(), '::')) {
                return $this->createClassConstantFetchNodeFromDoubleColonFormat($classConstantRename->getNewConstant());
            }
            $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($classConstantRename->getNewConstant());
            return $node;
        }
        return $node;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $classConstantRenames = $configuration[self::CLASS_CONSTANT_RENAME] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($classConstantRenames, \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant::class);
        $this->classConstantRenames = $classConstantRenames;
    }
    private function createClassConstantFetchNodeFromDoubleColonFormat(string $constant) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch
    {
        [$constantClass, $constantName] = \explode('::', $constant);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($constantClass), new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($constantName));
    }
}
