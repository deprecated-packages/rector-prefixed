<?php

declare (strict_types=1);
namespace Rector\Renaming\Rector\ClassConstFetch;

use RectorPrefix2020DecSat\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Renaming\ValueObject\RenameClassConstant;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix2020DecSat\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\RenameClassConstantRectorTest
 */
final class RenameClassConstantRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CLASS_CONSTANT_RENAME = 'constant_rename';
    /**
     * @var RenameClassConstant[]
     */
    private $classConstantRenames = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $configuration = [self::CLASS_CONSTANT_RENAME => [new \Rector\Renaming\ValueObject\RenameClassConstant('SomeClass', 'OLD_CONSTANT', 'NEW_CONSTANT'), new \Rector\Renaming\ValueObject\RenameClassConstant('SomeClass', 'OTHER_OLD_CONSTANT', 'DifferentClass::NEW_CONSTANT')]];
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
        foreach ($this->classConstantRenames as $classConstantRename) {
            if (!$this->isObjectType($node, $classConstantRename->getOldClass())) {
                continue;
            }
            if (!$this->isName($node->name, $classConstantRename->getOldConstant())) {
                continue;
            }
            if (\RectorPrefix2020DecSat\Nette\Utils\Strings::contains($classConstantRename->getNewConstant(), '::')) {
                return $this->createClassConstantFetchNodeFromDoubleColonFormat($classConstantRename->getNewConstant());
            }
            $node->name = new \PhpParser\Node\Identifier($classConstantRename->getNewConstant());
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
        \RectorPrefix2020DecSat\Webmozart\Assert\Assert::allIsInstanceOf($classConstantRenames, \Rector\Renaming\ValueObject\RenameClassConstant::class);
        $this->classConstantRenames = $classConstantRenames;
    }
    private function createClassConstantFetchNodeFromDoubleColonFormat(string $constant) : \PhpParser\Node\Expr\ClassConstFetch
    {
        [$constantClass, $constantName] = \explode('::', $constant);
        return new \PhpParser\Node\Expr\ClassConstFetch(new \PhpParser\Node\Name\FullyQualified($constantClass), new \PhpParser\Node\Identifier($constantName));
    }
}
