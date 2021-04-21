<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PhpDocNodeVisitor;

use RectorPrefix20210421\Nette\Utils\Strings;
use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\Type\ObjectType;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Renaming\ValueObject\PseudoNamespaceToNamespace;
use Rector\StaticTypeMapper\StaticTypeMapper;
use RectorPrefix20210421\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor;
final class UnderscoreRenamePhpDocNodeVisitor extends \RectorPrefix20210421\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var PseudoNamespaceToNamespace|null
     */
    private $pseudoNamespaceToNamespace;
    /**
     * @var \PhpParser\Node|null
     */
    private $currentPhpParserNode;
    public function __construct(\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->staticTypeMapper = $staticTypeMapper;
    }
    /**
     * @return void
     */
    public function beforeTraverse(\PHPStan\PhpDocParser\Ast\Node $node)
    {
        if ($this->pseudoNamespaceToNamespace === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException('Set PseudoNamespaceToNamespace first');
        }
        if (!$this->currentPhpParserNode instanceof \PhpParser\Node) {
            throw new \Rector\Core\Exception\ShouldNotHappenException('Set "$currentPhpParserNode" first');
        }
    }
    /**
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(\PHPStan\PhpDocParser\Ast\Node $node)
    {
        if (!$node instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return null;
        }
        if ($this->shouldSkip($node, $this->currentPhpParserNode, $this->pseudoNamespaceToNamespace)) {
            return null;
        }
        /** @var IdentifierTypeNode $node */
        $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($node, $this->currentPhpParserNode);
        if (!$staticType instanceof \PHPStan\Type\ObjectType) {
            return null;
        }
        // change underscore to \\
        $slashedName = '\\' . \RectorPrefix20210421\Nette\Utils\Strings::replace($staticType->getClassName(), '#_#', '\\');
        return new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($slashedName);
    }
    /**
     * @return void
     */
    public function setPseudoNamespaceToNamespace(\Rector\Renaming\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace)
    {
        $this->pseudoNamespaceToNamespace = $pseudoNamespaceToNamespace;
    }
    /**
     * @return void
     */
    public function setCurrentPhpParserNode(\PhpParser\Node $node)
    {
        $this->currentPhpParserNode = $node;
    }
    private function shouldSkip(\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $identifierTypeNode, \PhpParser\Node $phpParserNode, \Rector\Renaming\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace) : bool
    {
        $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($identifierTypeNode, $phpParserNode);
        if (!$staticType instanceof \PHPStan\Type\ObjectType) {
            return \true;
        }
        if (!\RectorPrefix20210421\Nette\Utils\Strings::startsWith($staticType->getClassName(), $pseudoNamespaceToNamespace->getNamespacePrefix())) {
            return \true;
        }
        // excluded?
        return \in_array($staticType->getClassName(), $pseudoNamespaceToNamespace->getExcludedClasses(), \true);
    }
}
