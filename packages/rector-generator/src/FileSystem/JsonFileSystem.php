<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\RectorGenerator\FileSystem;

use _PhpScoper0a2ac50786fa\Nette\Utils\Json;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
final class JsonFileSystem
{
    /**
     * @var JsonStringFormatter
     */
    private $jsonStringFormatter;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\RectorGenerator\FileSystem\JsonStringFormatter $jsonStringFormatter, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->jsonStringFormatter = $jsonStringFormatter;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return mixed[]
     */
    public function loadFileToJson(string $filePath) : array
    {
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return \_PhpScoper0a2ac50786fa\Nette\Utils\Json::decode($fileContent, \_PhpScoper0a2ac50786fa\Nette\Utils\Json::FORCE_ARRAY);
    }
    /**
     * @param mixed[] $json
     */
    public function saveJsonToFile(string $filePath, array $json) : void
    {
        $content = \_PhpScoper0a2ac50786fa\Nette\Utils\Json::encode($json, \_PhpScoper0a2ac50786fa\Nette\Utils\Json::PRETTY);
        $content = $this->jsonStringFormatter->inlineSections($content, ['keywords', 'bin']);
        $content = $this->jsonStringFormatter->inlineAuthors($content);
        // make sure there is newline in the end
        $content = \trim($content) . \PHP_EOL;
        $this->smartFileSystem->dumpFile($filePath, $content);
    }
}
