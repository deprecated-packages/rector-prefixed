<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class SerializerTypeTagValueNode extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    /**
     * @var string
     */
    private const NAME = 'name';
    public function getShortName() : string
    {
        return '_PhpScopere8e811afab72\\@Serializer\\Type';
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
        $newNameValue = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($this->items[self::NAME], $oldNamePattern, $newName);
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
