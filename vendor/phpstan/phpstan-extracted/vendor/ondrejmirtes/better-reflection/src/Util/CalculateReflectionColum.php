<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Exception\InvalidNodePosition;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Exception\NoNodePosition;
use function strlen;
use function strrpos;
/**
 * @internal
 */
final class CalculateReflectionColum
{
    /**
     * @throws InvalidNodePosition
     * @throws NoNodePosition
     */
    public static function getStartColumn(string $source, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : int
    {
        if (!$node->hasAttribute('startFilePos')) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Exception\NoNodePosition::fromNode($node);
        }
        return self::calculateColumn($source, $node->getStartFilePos());
    }
    /**
     * @throws InvalidNodePosition
     * @throws NoNodePosition
     */
    public static function getEndColumn(string $source, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : int
    {
        if (!$node->hasAttribute('endFilePos')) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Exception\NoNodePosition::fromNode($node);
        }
        return self::calculateColumn($source, $node->getEndFilePos());
    }
    /**
     * @throws InvalidNodePosition
     */
    private static function calculateColumn(string $source, int $position) : int
    {
        $sourceLength = \strlen($source);
        if ($position > $sourceLength) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Exception\InvalidNodePosition::fromPosition($position);
        }
        $lineStartPosition = \strrpos($source, "\n", $position - $sourceLength);
        if ($lineStartPosition === \false) {
            return $position + 1;
        }
        return $position - $lineStartPosition;
    }
}
