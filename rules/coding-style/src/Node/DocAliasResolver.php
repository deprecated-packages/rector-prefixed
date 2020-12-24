<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Node;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
final class DocAliasResolver
{
    /**
     * @var string
     * @see https://regex101.com/r/cWpliJ/1
     */
    private const DOC_ALIAS_REGEX = '#\\@(?<possible_alias>\\w+)(\\\\)?#s';
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @return string[]
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : array
    {
        $possibleDocAliases = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($node, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use(&$possibleDocAliases) : void {
            $docComment = $node->getDocComment();
            if ($docComment === null) {
                return;
            }
            /** @var PhpDocInfo $phpDocInfo */
            $phpDocInfo = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            $possibleDocAliases = $this->collectVarType($phpDocInfo, $possibleDocAliases);
            // e.g. "use Dotrine\ORM\Mapping as ORM" etc.
            $matches = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::matchAll($docComment->getText(), self::DOC_ALIAS_REGEX);
            foreach ($matches as $match) {
                $possibleDocAliases[] = $match['possible_alias'];
            }
        });
        return \array_unique($possibleDocAliases);
    }
    /**
     * @param string[] $possibleDocAliases
     * @return string[]
     */
    private function collectVarType(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, array $possibleDocAliases) : array
    {
        $possibleDocAliases = $this->appendPossibleAliases($phpDocInfo->getVarType(), $possibleDocAliases);
        $possibleDocAliases = $this->appendPossibleAliases($phpDocInfo->getReturnType(), $possibleDocAliases);
        foreach ($phpDocInfo->getParamTypesByName() as $paramType) {
            $possibleDocAliases = $this->appendPossibleAliases($paramType, $possibleDocAliases);
        }
        return $possibleDocAliases;
    }
    /**
     * @param string[] $possibleDocAliases
     * @return string[]
     */
    private function appendPossibleAliases(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $varType, array $possibleDocAliases) : array
    {
        if ($varType instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType) {
            $possibleDocAliases[] = $varType->getClassName();
        }
        if ($varType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            foreach ($varType->getTypes() as $type) {
                $possibleDocAliases = $this->appendPossibleAliases($type, $possibleDocAliases);
            }
        }
        return $possibleDocAliases;
    }
}
