<?php

declare (strict_types=1);
namespace Rector\Order\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\UnionType;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210125\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Order\Tests\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector\OrderConstructorDependenciesByTypeAlphabeticallyRectorTest
 */
final class OrderConstructorDependenciesByTypeAlphabeticallyRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Order __constructor dependencies by type A-Z', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
    private function shouldSkip(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isName($classMethod, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return \true;
        }
        /** @var SmartFileInfo $smartFileInfo */
        $smartFileInfo = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
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
    private function getSortedParams(\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $params = $classMethod->getParams();
        \usort($params, function (\PhpParser\Node\Param $firstParam, \PhpParser\Node\Param $secondParam) : int {
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
    private function isFileInfoMatch(\RectorPrefix20210125\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
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
    private function hasPrimitiveDataTypeParam(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        foreach ($classMethod->params as $param) {
            if ($param->type instanceof \PhpParser\Node\Identifier) {
                return \true;
            }
        }
        return \false;
    }
    private function hasParamWithNoType(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
    private function getParamType(\PhpParser\Node\Param $param)
    {
        return $param->type instanceof \PhpParser\Node\NullableType ? $param->type->type : $param->type;
    }
}
