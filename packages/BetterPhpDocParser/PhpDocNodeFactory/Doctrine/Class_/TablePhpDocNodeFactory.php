<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_;

use Doctrine\ORM\Mapping\Table;
use RectorPrefix20210317\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode;
use Rector\Core\Exception\ShouldNotHappenException;
final class TablePhpDocNodeFactory extends \Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface
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
    /**
     * @var ArrayPartPhpDocTagPrinter
     */
    private $arrayPartPhpDocTagPrinter;
    /**
     * @var TagValueNodePrinter
     */
    private $tagValueNodePrinter;
    public function __construct(\Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter, \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter, \Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_\IndexPhpDocNodeFactory $indexPhpDocNodeFactory, \Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_\UniqueConstraintPhpDocNodeFactory $uniqueConstraintPhpDocNodeFactory)
    {
        $this->indexPhpDocNodeFactory = $indexPhpDocNodeFactory;
        $this->uniqueConstraintPhpDocNodeFactory = $uniqueConstraintPhpDocNodeFactory;
        $this->arrayPartPhpDocTagPrinter = $arrayPartPhpDocTagPrinter;
        $this->tagValueNodePrinter = $tagValueNodePrinter;
    }
    /**
     * @return array<class-string<Table>>
     */
    public function getClasses() : array
    {
        return ['Doctrine\\ORM\\Mapping\\Table'];
    }
    /**
     * @param \PhpParser\Node $node
     * @param \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator
     * @param string $annotationClass
     */
    public function createFromNodeAndTokens($node, $tokenIterator, $annotationClass) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        if (!$node instanceof \PhpParser\Node\Stmt\Class_) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $table = $this->nodeAnnotationReader->readClassAnnotation($node, $annotationClass);
        if (!$table instanceof \Doctrine\ORM\Mapping\Table) {
            return null;
        }
        $annotationContent = $this->resolveContentFromTokenIterator($tokenIterator);
        $indexesContent = $this->annotationContentResolver->resolveNestedKey($annotationContent, 'indexes');
        $indexTagValueNodes = $this->indexPhpDocNodeFactory->createIndexTagValueNodes($table->indexes, $indexesContent);
        $indexesAroundSpaces = $this->matchCurlyBracketAroundSpaces($indexesContent);
        $haveIndexesFinalComma = (bool) \RectorPrefix20210317\Nette\Utils\Strings::match($indexesContent, self::SPACE_BEFORE_CLOSING_BRACKET_REGEX);
        $uniqueConstraintsContent = $this->annotationContentResolver->resolveNestedKey($annotationContent, 'uniqueConstraints');
        $uniqueConstraintAroundSpaces = $this->matchCurlyBracketAroundSpaces($uniqueConstraintsContent);
        $uniqueConstraintTagValueNodes = $this->uniqueConstraintPhpDocNodeFactory->createUniqueConstraintTagValueNodes($table->uniqueConstraints, $uniqueConstraintsContent);
        $haveUniqueConstraintsFinalComma = (bool) \RectorPrefix20210317\Nette\Utils\Strings::match($uniqueConstraintsContent, self::SPACE_BEFORE_CLOSING_BRACKET_REGEX);
        return new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode($this->arrayPartPhpDocTagPrinter, $this->tagValueNodePrinter, $table->name, $table->schema, $indexTagValueNodes, $uniqueConstraintTagValueNodes, $table->options, $annotationContent, $haveIndexesFinalComma, $haveUniqueConstraintsFinalComma, $indexesAroundSpaces, $uniqueConstraintAroundSpaces);
    }
}
