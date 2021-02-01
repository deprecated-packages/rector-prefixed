<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Property_;

use Doctrine\ORM\Mapping\JoinTable;
use RectorPrefix20210201\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode;
use Rector\Core\Exception\ShouldNotHappenException;
final class JoinTablePhpDocNodeFactory extends \Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface
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
        return ['Doctrine\\ORM\\Mapping\\JoinTable'];
    }
    /**
     * @return JoinTableTagValueNode|null
     */
    public function createFromNodeAndTokens(\PhpParser\Node $node, \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        if (!$node instanceof \PhpParser\Node\Stmt\Property) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $joinTable = $this->nodeAnnotationReader->readPropertyAnnotation($node, $annotationClass);
        if (!$joinTable instanceof \Doctrine\ORM\Mapping\JoinTable) {
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
        return new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode($joinTable->name, $joinTable->schema, $joinColumnValuesTags, $inverseJoinColumnValuesTags, $annotationContent, $joinColumnsAroundSpaces, $inverseJoinColumnAroundSpaces);
    }
    /**
     * @return JoinColumnTagValueNode[]
     */
    private function createJoinColumnTagValues(string $annotationContent, \Doctrine\ORM\Mapping\JoinTable $joinTable, string $type) : array
    {
        $joinColumnContents = $this->matchJoinColumnContents($annotationContent);
        $joinColumnValuesTags = [];
        if (!\in_array($type, [self::JOIN_COLUMNS, self::INVERSE_JOIN_COLUMNS], \true)) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $joinColumns = $type === self::JOIN_COLUMNS ? $joinTable->joinColumns : $joinTable->inverseJoinColumns;
        foreach ($joinColumns as $key => $joinColumn) {
            $subAnnotation = $joinColumnContents[$key];
            $items = $this->annotationItemsResolver->resolve($joinColumn);
            $joinColumnValuesTags[] = new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode($items, $subAnnotation['content'], $subAnnotation['tag']);
        }
        return $joinColumnValuesTags;
    }
    /**
     * @return string[][]
     */
    private function matchJoinColumnContents(string $annotationContent) : array
    {
        return \RectorPrefix20210201\Nette\Utils\Strings::matchAll($annotationContent, self::JOIN_COLUMN_REGEX);
    }
}
