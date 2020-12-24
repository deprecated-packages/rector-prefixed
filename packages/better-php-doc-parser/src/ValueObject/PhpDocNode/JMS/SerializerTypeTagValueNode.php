<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class SerializerTypeTagValueNode extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    /**
     * @var string
     */
    private const NAME = 'name';
    public function getShortName() : string
    {
        return '_PhpScoper0a6b37af0871\\@Serializer\\Type';
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
        $newNameValue = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($this->items[self::NAME], $oldNamePattern, $newName);
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
