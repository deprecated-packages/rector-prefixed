<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Property_;

use _PhpScoper2a4e7ab1ecbc\Doctrine\ORM\Mapping\JoinTable;
use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
final class JoinTablePhpDocNodeFactory extends \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface
{
    /**
     * @var string
     */
    private const INVERSE_JOIN_COLUMNS = 'inverseJoinColumns';
    /**
     * @var string
     */
    private const JOIN_COLUMNS = 'joinColumns';
    /**
     * @var string
     * @see https://regex101.com/r/5JVito/1
     */
    private const JOIN_COLUMN_REGEX = '#(?<tag>@(ORM\\\\)?JoinColumn)\\((?<content>.*?)\\),?#si';
    /**
     * @return string[]
     */
    public function getClasses() : array
    {
        return ['_PhpScoper2a4e7ab1ecbc\\Doctrine\\ORM\\Mapping\\JoinTable'];
    }
    /**
     * @return JoinTableTagValueNode|null
     */
    public function createFromNodeAndTokens(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        /** @var JoinTable|null $joinTable */
        $joinTable = $this->nodeAnnotationReader->readPropertyAnnotation($node, $annotationClass);
        if ($joinTable === null) {
            return null;
        }
        $annotationContent = $this->resolveContentFromTokenIterator($tokenIterator);
        $joinColumnsAnnotationContent = $this->annotationContentResolver->resolveNestedKey($annotationContent, self::JOIN_COLUMNS);
        $joinColumnValuesTags = $this->createJoinColumnTagValues($joinColumnsAnnotationContent, $joinTable, self::JOIN_COLUMNS);
        $joinColumnsAroundSpaces = $this->matchCurlyBracketAroundSpaces($joinColumnsAnnotationContent);
        // inversed join columns
        $inverseJoinColumnsAnnotationContent = $this->annotationContentResolver->resolveNestedKey($annotationContent, self::INVERSE_JOIN_COLUMNS);
        $inverseJoinColumnValuesTags = $this->createJoinColumnTagValues($inverseJoinColumnsAnnotationContent, $joinTable, self::INVERSE_JOIN_COLUMNS);
        $inverseJoinColumnAroundSpaces = $this->matchCurlyBracketAroundSpaces($inverseJoinColumnsAnnotationContent);
        return new \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode($joinTable->name, $joinTable->schema, $joinColumnValuesTags, $inverseJoinColumnValuesTags, $annotationContent, $joinColumnsAroundSpaces, $inverseJoinColumnAroundSpaces);
    }
    /**
     * @return JoinColumnTagValueNode[]
     */
    private function createJoinColumnTagValues(string $annotationContent, \_PhpScoper2a4e7ab1ecbc\Doctrine\ORM\Mapping\JoinTable $joinTable, string $type) : array
    {
        $joinColumnContents = $this->matchJoinColumnContents($annotationContent);
        $joinColumnValuesTags = [];
        if (!\in_array($type, [self::JOIN_COLUMNS, self::INVERSE_JOIN_COLUMNS], \true)) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        $joinColumns = $type === self::JOIN_COLUMNS ? $joinTable->joinColumns : $joinTable->inverseJoinColumns;
        foreach ($joinColumns as $key => $joinColumn) {
            $subAnnotation = $joinColumnContents[$key];
            $items = $this->annotationItemsResolver->resolve($joinColumn);
            $joinColumnValuesTags[] = new \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode($items, $subAnnotation['content'], $subAnnotation['tag']);
        }
        return $joinColumnValuesTags;
    }
    /**
     * @return string[][]
     */
    private function matchJoinColumnContents(string $annotationContent) : array
    {
        return \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::matchAll($annotationContent, self::JOIN_COLUMN_REGEX);
    }
}
