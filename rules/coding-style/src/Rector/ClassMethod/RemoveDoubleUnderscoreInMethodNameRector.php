<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ObjectMagicMethods;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://twitter.com/afilina & Zenika (CAN) for sponsoring this rule - visit them on https://zenika.ca/en/en
 *
 * @see \Rector\CodingStyle\Tests\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector\RemoveDoubleUnderscoreInMethodNameRectorTest
 */
final class RemoveDoubleUnderscoreInMethodNameRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/oRrhDJ/3
     */
    private const DOUBLE_UNDERSCORE_START_REGEX = '#^__(.+)#';
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Non-magic PHP object methods cannot start with "__"', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function __getName($anotherObject)
    {
        $anotherObject->__getSurname();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function getName($anotherObject)
    {
        $anotherObject->getSurname();
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param ClassMethod|MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $methodName = $this->getName($node->name);
        if ($methodName === null) {
            return null;
        }
        if (\in_array($methodName, \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ObjectMagicMethods::METHOD_NAMES, \true)) {
            return null;
        }
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($methodName, self::DOUBLE_UNDERSCORE_START_REGEX)) {
            return null;
        }
        $newName = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::substring($methodName, 2);
        if (\is_numeric($newName[0])) {
            return null;
        }
        $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($newName);
        return $node;
    }
}
