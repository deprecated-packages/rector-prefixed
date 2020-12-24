<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Order\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Order\Tests\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector\OrderConstructorDependenciesByTypeAlphabeticallyRectorTest
 */
final class OrderConstructorDependenciesByTypeAlphabeticallyRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const SKIP_PATTERNS = '$skipPatterns';
    /**
     * @var string[]
     */
    private $skipPatterns = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Order __constructor dependencies by type A-Z', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct(
        LatteToTwigConverter $latteToTwigConverter,
        SymfonyStyle $symfonyStyle,
        LatteAndTwigFinder $latteAndTwigFinder,
        SmartFileSystem $smartFileSystem
    ) {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct(
        LatteAndTwigFinder $latteAndTwigFinder,
        LatteToTwigConverter $latteToTwigConverter,
        SmartFileSystem $smartFileSystem,
        SymfonyStyle $symfonyStyle
    ) {
    }
}
CODE_SAMPLE
, [self::SKIP_PATTERNS => ['Cla*ame', 'Ano?herClassName']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $node->params = $this->getSortedParams($node);
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->skipPatterns = $configuration[self::SKIP_PATTERNS] ?? [];
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isName($classMethod, \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return \true;
        }
        /** @var SmartFileInfo $smartFileInfo */
        $smartFileInfo = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($this->isFileInfoMatch($smartFileInfo)) {
            return \true;
        }
        if ($classMethod->params === []) {
            return \true;
        }
        if ($this->hasPrimitiveDataTypeParam($classMethod)) {
            return \true;
        }
        return $this->hasParamWithNoType($classMethod);
    }
    /**
     * @return Param[]
     */
    private function getSortedParams(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $params = $classMethod->getParams();
        \usort($params, function (\_PhpScopere8e811afab72\PhpParser\Node\Param $firstParam, \_PhpScopere8e811afab72\PhpParser\Node\Param $secondParam) : int {
            /** @var Name $firstParamType */
            $firstParamType = $this->getParamType($firstParam);
            /** @var Name $secondParamType */
            $secondParamType = $this->getParamType($secondParam);
            return $this->getShortName($firstParamType) <=> $this->getShortName($secondParamType);
        });
        return $params;
    }
    /**
     * Match file against matches, no patterns provided, then it matches
     */
    private function isFileInfoMatch(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        if ($this->skipPatterns === []) {
            return \true;
        }
        foreach ($this->skipPatterns as $pattern) {
            if (\fnmatch($pattern, $smartFileInfo->getRelativeFilePath(), \FNM_NOESCAPE)) {
                return \true;
            }
        }
        return \false;
    }
    private function hasPrimitiveDataTypeParam(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        foreach ($classMethod->params as $param) {
            if ($param->type instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
                return \true;
            }
        }
        return \false;
    }
    private function hasParamWithNoType(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        foreach ($classMethod->params as $param) {
            if ($param->type === null) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return Identifier|Name|UnionType|null
     */
    private function getParamType(\_PhpScopere8e811afab72\PhpParser\Node\Param $param)
    {
        return $param->type instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType ? $param->type->type : $param->type;
    }
}
