<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping\Table;
use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
final class TablePhpDocNodeFactory extends \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_\IndexPhpDocNodeFactory $indexPhpDocNodeFactory, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_\UniqueConstraintPhpDocNodeFactory $uniqueConstraintPhpDocNodeFactory)
    {
        $this->indexPhpDocNodeFactory = $indexPhpDocNodeFactory;
        $this->uniqueConstraintPhpDocNodeFactory = $uniqueConstraintPhpDocNodeFactory;
    }
    /**
     * @return string[]
     */
    public function getClasses() : array
    {
        return ['_PhpScoperb75b35f52b74\\Doctrine\\ORM\\Mapping\\Table'];
    }
    public function createFromNodeAndTokens(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
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
        $haveIndexesFinalComma = (bool) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($indexesContent, self::SPACE_BEFORE_CLOSING_BRACKET_REGEX);
        $uniqueConstraintsContent = $this->annotationContentResolver->resolveNestedKey($annotationContent, 'uniqueConstraints');
        $uniqueConstraintAroundSpaces = $this->matchCurlyBracketAroundSpaces($uniqueConstraintsContent);
        $uniqueConstraintTagValueNodes = $this->uniqueConstraintPhpDocNodeFactory->createUniqueConstraintTagValueNodes($table->uniqueConstraints, $uniqueConstraintsContent);
        $haveUniqueConstraintsFinalComma = (bool) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($uniqueConstraintsContent, self::SPACE_BEFORE_CLOSING_BRACKET_REGEX);
        return new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode($table->name, $table->schema, $indexTagValueNodes, $uniqueConstraintTagValueNodes, $table->options, $annotationContent, $haveIndexesFinalComma, $haveUniqueConstraintsFinalComma, $indexesAroundSpaces, $uniqueConstraintAroundSpaces);
    }
}
