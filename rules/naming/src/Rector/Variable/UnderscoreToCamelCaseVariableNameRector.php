<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Rector\Variable;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\Rector\Core\Php\ReservedKeywordAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Core\Util\StaticRectorStrings;
use _PhpScoper0a2ac50786fa\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver;
use _PhpScoper0a2ac50786fa\Rector\Naming\ParamRenamer\ParamRenamer;
use _PhpScoper0a2ac50786fa\Rector\Naming\ValueObjectFactory\ParamRenameFactory;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Variable\UnderscoreToCamelCaseVariableNameRector\UnderscoreToCamelCaseVariableNameRectorTest
 */
final class UnderscoreToCamelCaseVariableNameRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\Php\ReservedKeywordAnalyzer $reservedKeywordAnalyzer, \_PhpScoper0a2ac50786fa\Rector\Naming\ValueObjectFactory\ParamRenameFactory $paramRenameFactory, \_PhpScoper0a2ac50786fa\Rector\Naming\ParamRenamer\ParamRenamer $underscoreCamelCaseParamRenamer, \_PhpScoper0a2ac50786fa\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver $underscoreCamelCaseExpectedNameResolver)
    {
        $this->reservedKeywordAnalyzer = $reservedKeywordAnalyzer;
        $this->paramRenameFactory = $paramRenameFactory;
        $this->underscoreCamelCaseExpectedNameResolver = $underscoreCamelCaseExpectedNameResolver;
        $this->paramRenamer = $underscoreCamelCaseParamRenamer;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change under_score names to camelCase', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $nodeName = $this->getName($node);
        if ($nodeName === null) {
            return null;
        }
        if (!\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($nodeName, '_')) {
            return null;
        }
        if ($this->reservedKeywordAnalyzer->isNativeVariable($nodeName)) {
            return null;
        }
        $camelCaseName = \_PhpScoper0a2ac50786fa\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($nodeName);
        if ($camelCaseName === 'this' || $camelCaseName === '' || \is_numeric($camelCaseName[0])) {
            return null;
        }
        $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Param) {
            return $this->renameParam($parent);
        }
        $node->name = $camelCaseName;
        return $node;
    }
    private function renameParam(\_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable
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
