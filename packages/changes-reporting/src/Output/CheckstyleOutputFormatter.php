<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ChangesReporting\Output;

use DOMDocument;
use _PhpScoperb75b35f52b74\Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use _PhpScoperb75b35f52b74\Rector\ChangesReporting\Contract\Output\OutputFormatterInterface;
use _PhpScoperb75b35f52b74\Rector\ChangesReporting\Xml\CheckstyleDOMElementFactory;
/**
 * Inspired by https://github.com/phpstan/phpstan-src/commit/fa1f416981438b80e2f39eabd9f1b62fca9a6803#diff-7a7d635d9f9cf3388e34d414731dece3
 */
final class CheckstyleOutputFormatter implements \_PhpScoperb75b35f52b74\Rector\ChangesReporting\Contract\Output\OutputFormatterInterface
{
    /**
     * @var string
     */
    public const NAME = 'checkstyle';
    /**
     * @var CheckstyleDOMElementFactory
     */
    private $checkstyleDOMElementFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\ChangesReporting\Xml\CheckstyleDOMElementFactory $checkstyleDOMElementFactory)
    {
        $this->checkstyleDOMElementFactory = $checkstyleDOMElementFactory;
    }
    public function getName() : string
    {
        return self::NAME;
    }
    public function report(\_PhpScoperb75b35f52b74\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector) : void
    {
        $domDocument = new \DOMDocument('1.0', 'UTF-8');
        $domElement = $this->checkstyleDOMElementFactory->create($domDocument, $errorAndDiffCollector);
        $domDocument->appendChild($domElement);
        // pretty print with spaces
        $domDocument->formatOutput = \true;
        echo $domDocument->saveXML();
    }
}
