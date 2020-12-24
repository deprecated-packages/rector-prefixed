<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Order\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\NullableType;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\UnionType;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Order\Tests\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector\OrderConstructorDependenciesByTypeAlphabeticallyRectorTest
 */
final class OrderConstructorDependenciesByTypeAlphabeticallyRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Order __constructor dependencies by type A-Z', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
    private function shouldSkip(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isName($classMethod, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return \true;
        }
        /** @var SmartFileInfo $smartFileInfo */
        $smartFileInfo = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
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
    private function getSortedParams(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $params = $classMethod->getParams();
        \usort($params, function (\_PhpScoper0a6b37af0871\PhpParser\Node\Param $firstParam, \_PhpScoper0a6b37af0871\PhpParser\Node\Param $secondParam) : int {
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
    private function isFileInfoMatch(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
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
    private function hasPrimitiveDataTypeParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        foreach ($classMethod->params as $param) {
            if ($param->type instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier) {
                return \true;
            }
        }
        return \false;
    }
    private function hasParamWithNoType(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
    private function getParamType(\_PhpScoper0a6b37af0871\PhpParser\Node\Param $param)
    {
        return $param->type instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\NullableType ? $param->type->type : $param->type;
    }
}
