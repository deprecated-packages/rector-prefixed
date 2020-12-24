<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassConstFetch;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector\RenameClassConstantsUseToStringsRectorTest
 */
final class RenameClassConstantsUseToStringsRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const OLD_CONSTANTS_TO_NEW_VALUES_BY_TYPE = '$oldConstantsToNewValuesByType';
    /**
     * @var string[][]
     */
    private $oldConstantsToNewValuesByType = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces constant by value', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('$value === Nette\\Configurator::DEVELOPMENT', '$value === "development"', [self::OLD_CONSTANTS_TO_NEW_VALUES_BY_TYPE => ['_PhpScoper0a6b37af0871\\Nette\\Configurator' => ['DEVELOPMENT' => 'development', 'PRODUCTION' => 'production']]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch::class];
    }
    /**
     * @param ClassConstFetch $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach ($this->oldConstantsToNewValuesByType as $type => $oldConstantsToNewValues) {
            if (!$this->isObjectType($node->class, $type)) {
                continue;
            }
            foreach ($oldConstantsToNewValues as $oldConstant => $newValue) {
                if (!$this->isName($node->name, $oldConstant)) {
                    continue;
                }
                return new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_($newValue);
            }
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->oldConstantsToNewValuesByType = $configuration[self::OLD_CONSTANTS_TO_NEW_VALUES_BY_TYPE] ?? [];
    }
}
