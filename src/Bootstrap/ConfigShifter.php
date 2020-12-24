<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Bootstrap;

use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ConfigShifter
{
    /**
     * Shift input config as last, so the parameters override previous rules loaded from sets
     *
     * @param SmartFileInfo[] $configFileInfos
     * @return SmartFileInfo[]
     * @noRector
     */
    public function shiftInputConfigAsLast(array $configFileInfos, ?\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $inputConfigFileInfo) : array
    {
        if ($inputConfigFileInfo === null) {
            return $configFileInfos;
        }
        $mainConfigShiftedAsLast = [];
        foreach ($configFileInfos as $configFileInfo) {
            if ($configFileInfo !== $inputConfigFileInfo) {
                $mainConfigShiftedAsLast[] = $configFileInfo;
            }
        }
        $mainConfigShiftedAsLast[] = $inputConfigFileInfo;
        return $mainConfigShiftedAsLast;
    }
}
