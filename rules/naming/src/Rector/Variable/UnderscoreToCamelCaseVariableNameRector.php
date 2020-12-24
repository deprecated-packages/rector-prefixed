<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Rector\Variable;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\Rector\Core\Php\ReservedKeywordAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings;
use _PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver;
use _PhpScoperb75b35f52b74\Rector\Naming\ParamRenamer\ParamRenamer;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObjectFactory\ParamRenameFactory;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Variable\UnderscoreToCamelCaseVariableNameRector\UnderscoreToCamelCaseVariableNameRectorTest
 */
final class UnderscoreToCamelCaseVariableNameRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ReservedKeywordAnalyzer
     */
    private $reservedKeywordAnalyzer;
    /**
     * @var ParamRenameFactory
     */
    private $paramRenameFactory;
    /**
     * @var UnderscoreCamelCaseExpectedNameResolver
     */
    private $underscoreCamelCaseExpectedNameResolver;
    /**
     * @var ParamRenamer
     */
    private $paramRenamer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\Php\ReservedKeywordAnalyzer $reservedKeywordAnalyzer, \_PhpScoperb75b35f52b74\Rector\Naming\ValueObjectFactory\ParamRenameFactory $paramRenameFactory, \_PhpScoperb75b35f52b74\Rector\Naming\ParamRenamer\ParamRenamer $underscoreCamelCaseParamRenamer, \_PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver $underscoreCamelCaseExpectedNameResolver)
    {
        $this->reservedKeywordAnalyzer = $reservedKeywordAnalyzer;
        $this->paramRenameFactory = $paramRenameFactory;
        $this->underscoreCamelCaseExpectedNameResolver = $underscoreCamelCaseExpectedNameResolver;
        $this->paramRenamer = $underscoreCamelCaseParamRenamer;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change under_score names to camelCase', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($a_b)
    {
        $some_value = $a_b;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($aB)
    {
        $someValue = $aB;
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $nodeName = $this->getName($node);
        if ($nodeName === null) {
            return null;
        }
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($nodeName, '_')) {
            return null;
        }
        if ($this->reservedKeywordAnalyzer->isNativeVariable($nodeName)) {
            return null;
        }
        $camelCaseName = \_PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($nodeName);
        if ($camelCaseName === 'this' || $camelCaseName === '' || \is_numeric($camelCaseName[0])) {
            return null;
        }
        $parent = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Param) {
            return $this->renameParam($parent);
        }
        $node->name = $camelCaseName;
        return $node;
    }
    private function renameParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable
    {
        $paramRename = $this->paramRenameFactory->create($param, $this->underscoreCamelCaseExpectedNameResolver);
        if ($paramRename === null) {
            return null;
        }
        $renamedParam = $this->paramRenamer->rename($paramRename);
        if ($renamedParam === null) {
            return null;
        }
        /** @var Variable $variable */
        $variable = $renamedParam->var;
        return $variable;
    }
}
