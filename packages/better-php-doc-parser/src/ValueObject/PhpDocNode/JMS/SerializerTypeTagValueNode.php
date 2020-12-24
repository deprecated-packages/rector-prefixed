<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class SerializerTypeTagValueNode extends \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    /**
     * @var string
     */
    private const NAME = 'name';
    public function getShortName() : string
    {
        return '_PhpScoperb75b35f52b74\\@Serializer\\Type';
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
        $newNameValue = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace($this->items[self::NAME], $oldNamePattern, $newName);
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
