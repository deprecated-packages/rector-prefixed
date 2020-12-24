<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Rector\String_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\StringToClassConstant;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\String_\StringToClassConstantRector\StringToClassConstantRectorTest
 */
final class StringToClassConstantRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const STRINGS_TO_CLASS_CONSTANTS = 'strings_to_class_constants';
    /**
     * @var StringToClassConstant[]
     */
    private $stringsToClassConstants = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes strings to specific constants', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeSubscriber
{
    public static function getSubscribedEvents()
    {
        return ['compiler.post_dump' => 'compile'];
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeSubscriber
{
    public static function getSubscribedEvents()
    {
        return [\Yet\AnotherClass::CONSTANT => 'compile'];
    }
}
CODE_SAMPLE
, [self::STRINGS_TO_CLASS_CONSTANTS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\StringToClassConstant('compiler.post_dump', '_PhpScoperb75b35f52b74\\Yet\\AnotherClass', 'CONSTANT')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_::class];
    }
    /**
     * @param String_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($this->stringsToClassConstants as $stringToClassConstant) {
            if (!$this->isValue($node, $stringToClassConstant->getString())) {
                continue;
            }
            return $this->createClassConstFetch($stringToClassConstant->getClass(), $stringToClassConstant->getConstant());
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $stringToClassConstants = $configuration[self::STRINGS_TO_CLASS_CONSTANTS] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($stringToClassConstants, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\StringToClassConstant::class);
        $this->stringsToClassConstants = $stringToClassConstants;
    }
}
