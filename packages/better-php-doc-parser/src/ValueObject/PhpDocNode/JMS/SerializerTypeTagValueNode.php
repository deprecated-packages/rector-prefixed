<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class SerializerTypeTagValueNode extends \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    /**
     * @var string
     */
    private const NAME = 'name';
    public function getShortName() : string
    {
        return '_PhpScoper2a4e7ab1ecbc\\@Serializer\\Type';
    }
    public function changeName(string $newName) : void
    {
        $this->items[self::NAME] = $newName;
    }
    public function getName() : string
    {
        return $this->items[self::NAME];
    }
    public function replaceName(string $oldName, string $newName) : bool
    {
        $oldNamePattern = '#\\b' . \preg_quote($oldName, '#') . '\\b#';
        $newNameValue = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::replace($this->items[self::NAME], $oldNamePattern, $newName);
        if ($newNameValue !== $this->items[self::NAME]) {
            $this->changeName($newNameValue);
            return \true;
        }
        return \false;
    }
    public function getSilentKey() : string
    {
        return self::NAME;
    }
}
