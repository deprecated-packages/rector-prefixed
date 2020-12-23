<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_;

use _PhpScoper0a2ac50786fa\Doctrine\ORM\Mapping\Table;
use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
final class TablePhpDocNodeFactory extends \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface
{
    /**
     * @var string
     * @see https://regex101.com/r/HKjBVt/1
     */
    private const SPACE_BEFORE_CLOSING_BRACKET_REGEX = '#,(\\s+)?}$#m';
    /**
     * @var IndexPhpDocNodeFactory
     */
    private $indexPhpDocNodeFactory;
    /**
     * @var UniqueConstraintPhpDocNodeFactory
     */
    private $uniqueConstraintPhpDocNodeFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_\IndexPhpDocNodeFactory $indexPhpDocNodeFactory, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_\UniqueConstraintPhpDocNodeFactory $uniqueConstraintPhpDocNodeFactory)
    {
        $this->indexPhpDocNodeFactory = $indexPhpDocNodeFactory;
        $this->uniqueConstraintPhpDocNodeFactory = $uniqueConstraintPhpDocNodeFactory;
    }
    /**
     * @return string[]
     */
    public function getClasses() : array
    {
        return ['_PhpScoper0a2ac50786fa\\Doctrine\\ORM\\Mapping\\Table'];
    }
    public function createFromNodeAndTokens(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        /** @var Table|null $table */
        $table = $this->nodeAnnotationReader->readClassAnnotation($node, $annotationClass);
        if ($table === null) {
            return null;
        }
        $annotationContent = $this->resolveContentFromTokenIterator($tokenIterator);
        $indexesContent = $this->annotationContentResolver->resolveNestedKey($annotationContent, 'indexes');
        $indexTagValueNodes = $this->indexPhpDocNodeFactory->createIndexTagValueNodes($table->indexes, $indexesContent);
        $indexesAroundSpaces = $this->matchCurlyBracketAroundSpaces($indexesContent);
        $haveIndexesFinalComma = (bool) \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::match($indexesContent, self::SPACE_BEFORE_CLOSING_BRACKET_REGEX);
        $uniqueConstraintsContent = $this->annotationContentResolver->resolveNestedKey($annotationContent, 'uniqueConstraints');
        $uniqueConstraintAroundSpaces = $this->matchCurlyBracketAroundSpaces($uniqueConstraintsContent);
        $uniqueConstraintTagValueNodes = $this->uniqueConstraintPhpDocNodeFactory->createUniqueConstraintTagValueNodes($table->uniqueConstraints, $uniqueConstraintsContent);
        $haveUniqueConstraintsFinalComma = (bool) \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::match($uniqueConstraintsContent, self::SPACE_BEFORE_CLOSING_BRACKET_REGEX);
        return new \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode($table->name, $table->schema, $indexTagValueNodes, $uniqueConstraintTagValueNodes, $table->options, $annotationContent, $haveIndexesFinalComma, $haveUniqueConstraintsFinalComma, $indexesAroundSpaces, $uniqueConstraintAroundSpaces);
    }
}
