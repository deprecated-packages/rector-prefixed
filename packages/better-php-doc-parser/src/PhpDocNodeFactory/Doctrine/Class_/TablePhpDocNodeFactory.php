<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_;

use _PhpScopere8e811afab72\Doctrine\ORM\Mapping\Table;
use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
final class TablePhpDocNodeFactory extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface
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
    public function __construct(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_\IndexPhpDocNodeFactory $indexPhpDocNodeFactory, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_\UniqueConstraintPhpDocNodeFactory $uniqueConstraintPhpDocNodeFactory)
    {
        $this->indexPhpDocNodeFactory = $indexPhpDocNodeFactory;
        $this->uniqueConstraintPhpDocNodeFactory = $uniqueConstraintPhpDocNodeFactory;
    }
    /**
     * @return string[]
     */
    public function getClasses() : array
    {
        return ['_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\Table'];
    }
    public function createFromNodeAndTokens(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
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
        $haveIndexesFinalComma = (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($indexesContent, self::SPACE_BEFORE_CLOSING_BRACKET_REGEX);
        $uniqueConstraintsContent = $this->annotationContentResolver->resolveNestedKey($annotationContent, 'uniqueConstraints');
        $uniqueConstraintAroundSpaces = $this->matchCurlyBracketAroundSpaces($uniqueConstraintsContent);
        $uniqueConstraintTagValueNodes = $this->uniqueConstraintPhpDocNodeFactory->createUniqueConstraintTagValueNodes($table->uniqueConstraints, $uniqueConstraintsContent);
        $haveUniqueConstraintsFinalComma = (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($uniqueConstraintsContent, self::SPACE_BEFORE_CLOSING_BRACKET_REGEX);
        return new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode($table->name, $table->schema, $indexTagValueNodes, $uniqueConstraintTagValueNodes, $table->options, $annotationContent, $haveIndexesFinalComma, $haveUniqueConstraintsFinalComma, $indexesAroundSpaces, $uniqueConstraintAroundSpaces);
    }
}
