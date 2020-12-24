<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Variable;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Php\ReservedKeywordAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\ParamRenamer\ParamRenamer;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObjectFactory\ParamRenameFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Variable\UnderscoreToCamelCaseVariableNameRector\UnderscoreToCamelCaseVariableNameRectorTest
 */
final class UnderscoreToCamelCaseVariableNameRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Php\ReservedKeywordAnalyzer $reservedKeywordAnalyzer, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObjectFactory\ParamRenameFactory $paramRenameFactory, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\ParamRenamer\ParamRenamer $underscoreCamelCaseParamRenamer, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver $underscoreCamelCaseExpectedNameResolver)
    {
        $this->reservedKeywordAnalyzer = $reservedKeywordAnalyzer;
        $this->paramRenameFactory = $paramRenameFactory;
        $this->underscoreCamelCaseExpectedNameResolver = $underscoreCamelCaseExpectedNameResolver;
        $this->paramRenamer = $underscoreCamelCaseParamRenamer;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change under_score names to camelCase', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $nodeName = $this->getName($node);
        if ($nodeName === null) {
            return null;
        }
        if (!\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($nodeName, '_')) {
            return null;
        }
        if ($this->reservedKeywordAnalyzer->isNativeVariable($nodeName)) {
            return null;
        }
        $camelCaseName = \_PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($nodeName);
        if ($camelCaseName === 'this') {
            return null;
        }
        if ($camelCaseName === '') {
            return null;
        }
        if (\is_numeric($camelCaseName[0])) {
            return null;
        }
        $parent = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param) {
            return $this->renameParam($parent);
        }
        $node->name = $camelCaseName;
        return $node;
    }
    private function renameParam(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable
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
