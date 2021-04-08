<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Node;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
use RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class DocAliasResolver
{
    /**
     * @var string
     * @see https://regex101.com/r/cWpliJ/1
     */
    private const DOC_ALIAS_REGEX = '#\\@(?<possible_alias>\\w+)(\\\\)?#s';
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    /**
     * @return string[]
     */
    public function resolve(\PhpParser\Node $node) : array
    {
        $possibleDocAliases = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($node, function (\PhpParser\Node $node) use(&$possibleDocAliases) : void {
            $docComment = $node->getDocComment();
            if (!$docComment instanceof \PhpParser\Comment\Doc) {
                return;
            }
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
            $possibleDocAliases = $this->collectVarType($phpDocInfo, $possibleDocAliases);
            // e.g. "use Dotrine\ORM\Mapping as ORM" etc.
            $matches = \RectorPrefix20210408\Nette\Utils\Strings::matchAll($docComment->getText(), self::DOC_ALIAS_REGEX);
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
    private function collectVarType(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, array $possibleDocAliases) : array
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
    private function appendPossibleAliases(\PHPStan\Type\Type $varType, array $possibleDocAliases) : array
    {
        if ($varType instanceof \Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType) {
            $possibleDocAliases[] = $varType->getClassName();
        }
        if ($varType instanceof \PHPStan\Type\UnionType) {
            foreach ($varType->getTypes() as $type) {
                $possibleDocAliases = $this->appendPossibleAliases($type, $possibleDocAliases);
            }
        }
        return $possibleDocAliases;
    }
}
