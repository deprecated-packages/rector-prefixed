<?php

declare (strict_types=1);
namespace Rector\Doctrine\PhpDoc\Node\Property_;

use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\BetterPhpDocParser\ValueObject\AroundSpaces;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Doctrine\PhpDoc\Node\AbstractDoctrineTagValueNode;
final class JoinTableTagValueNode extends \Rector\Doctrine\PhpDoc\Node\AbstractDoctrineTagValueNode
{
    /**
     * @var string
     */
    private const JOIN_COLUMNS = 'joinColumns';
    /**
     * @var string
     */
    private const INVERSE_JOIN_COLUMNS = 'inverseJoinColumns';
    /**
     * @var string|null
     */
    private $name;
    /**
     * @var JoinColumnTagValueNode[]
     */
    private $joinColumns = [];
    /**
     * @var JoinColumnTagValueNode[]
     */
    private $inverseJoinColumns = [];
    /**
     * @var AroundSpaces|null
     */
    private $inverseJoinColumnsAroundSpaces;
    /**
     * @var AroundSpaces|null
     */
    private $joinColumnsAroundSpaces;
    /**
     * @var string|null
     */
    private $schema;
    /**
     * @param JoinColumnTagValueNode[] $joinColumns
     * @param JoinColumnTagValueNode[] $inverseJoinColumns
     */
    public function __construct(\Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter, \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter, ?string $name, ?string $schema = null, array $joinColumns = [], array $inverseJoinColumns = [], ?string $originalContent = null, ?\Rector\BetterPhpDocParser\ValueObject\AroundSpaces $joinColumnsAroundSpaces = null, ?\Rector\BetterPhpDocParser\ValueObject\AroundSpaces $inverseJoinColumnsAroundSpaces = null)
    {
        $this->name = $name;
        $this->schema = $schema;
        $this->joinColumns = $joinColumns;
        $this->inverseJoinColumns = $inverseJoinColumns;
        $this->inverseJoinColumnsAroundSpaces = $inverseJoinColumnsAroundSpaces;
        $this->joinColumnsAroundSpaces = $joinColumnsAroundSpaces;
        parent::__construct($arrayPartPhpDocTagPrinter, $tagValueNodePrinter, [], $originalContent);
    }
    public function __toString() : string
    {
        $items = $this->createItems();
        $items = $this->tagValueNodePrinter->makeKeysExplicit($items, $this->tagValueNodeConfiguration);
        return $this->printContentItems($items);
    }
    public function getShortName() : string
    {
        return '@ORM\\JoinTable';
    }
    /**
     * @return string[]
     */
    private function createItems() : array
    {
        $items = [];
        if ($this->name !== null) {
            $items['name'] = \sprintf('"%s"', $this->name);
        }
        if ($this->schema !== null) {
            $items['schema'] = \sprintf('"%s"', $this->schema);
        }
        $joinColumnItems = $this->createJoinColumnItems(self::JOIN_COLUMNS, self::INVERSE_JOIN_COLUMNS);
        return \array_merge($items, $joinColumnItems);
    }
    /**
     * @return array<string, mixed>
     */
    private function createJoinColumnItems(string $joinColumnsKey, string $inverseJoinColumnsKey) : array
    {
        $items = [];
        if ($this->joinColumns !== []) {
            if (!$this->joinColumnsAroundSpaces instanceof \Rector\BetterPhpDocParser\ValueObject\AroundSpaces) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $items[$joinColumnsKey] = $this->printNestedTag($this->joinColumns, \false, $this->joinColumnsAroundSpaces->getOpeningSpace(), $this->joinColumnsAroundSpaces->getClosingSpace());
        }
        if ($this->inverseJoinColumns !== []) {
            if (!$this->inverseJoinColumnsAroundSpaces instanceof \Rector\BetterPhpDocParser\ValueObject\AroundSpaces) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $items[$inverseJoinColumnsKey] = $this->printNestedTag($this->inverseJoinColumns, \false, $this->inverseJoinColumnsAroundSpaces->getOpeningSpace(), $this->inverseJoinColumnsAroundSpaces->getClosingSpace());
        }
        return $items;
    }
}
