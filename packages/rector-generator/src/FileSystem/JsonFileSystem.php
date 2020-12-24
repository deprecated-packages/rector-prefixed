<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RectorGenerator\FileSystem;

use _PhpScoperb75b35f52b74\Nette\Utils\Json;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\RectorGenerator\FileSystem\JsonStringFormatter $jsonStringFormatter, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
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
        return \_PhpScoperb75b35f52b74\Nette\Utils\Json::decode($fileContent, \_PhpScoperb75b35f52b74\Nette\Utils\Json::FORCE_ARRAY);
    }
    /**
     * @param mixed[] $json
     */
    public function saveJsonToFile(string $filePath, array $json) : void
    {
        $content = \_PhpScoperb75b35f52b74\Nette\Utils\Json::encode($json, \_PhpScoperb75b35f52b74\Nette\Utils\Json::PRETTY);
        $content = $this->jsonStringFormatter->inlineSections($content, ['keywords', 'bin']);
        $content = $this->jsonStringFormatter->inlineAuthors($content);
        // make sure there is newline in the end
        $content = \trim($content) . \PHP_EOL;
        $this->smartFileSystem->dumpFile($filePath, $content);
    }
}
