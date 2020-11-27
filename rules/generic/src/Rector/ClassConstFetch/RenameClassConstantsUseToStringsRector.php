<?php

declare (strict_types=1);
namespace Rector\Generic\Rector\ClassConstFetch;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Scalar\String_;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector\RenameClassConstantsUseToStringsRectorTest
 */
final class RenameClassConstantsUseToStringsRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const OLD_CONSTANTS_TO_NEW_VALUES_BY_TYPE = '$oldConstantsToNewValuesByType';
    /**
     * @var string[][]
     */
    private $oldConstantsToNewValuesByType = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces constant by value', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('$value === Nette\\Configurator::DEVELOPMENT', '$value === "development"', [self::OLD_CONSTANTS_TO_NEW_VALUES_BY_TYPE => ['_PhpScoper006a73f0e455\\Nette\\Configurator' => ['DEVELOPMENT' => 'development', 'PRODUCTION' => 'production']]])]);
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
        foreach ($this->oldConstantsToNewValuesByType as $type => $oldConstantsToNewValues) {
            if (!$this->isObjectType($node->class, $type)) {
                continue;
            }
            foreach ($oldConstantsToNewValues as $oldConstant => $newValue) {
                if (!$this->isName($node->name, $oldConstant)) {
                    continue;
                }
                return new \PhpParser\Node\Scalar\String_($newValue);
            }
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->oldConstantsToNewValuesByType = $configuration[self::OLD_CONSTANTS_TO_NEW_VALUES_BY_TYPE] ?? [];
    }
}
