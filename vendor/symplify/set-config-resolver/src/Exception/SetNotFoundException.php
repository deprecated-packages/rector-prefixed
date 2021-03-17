<?php

declare (strict_types=1);
namespace RectorPrefix20210317\Symplify\SetConfigResolver\Exception;

use Exception;
final class SetNotFoundException extends \Exception
{
    /**
     * @var string
     */
    private $setName;
    /**
     * @var string[]
     */
    private $availableSetNames = [];
    /**
     * @param string[] $availableSetNames
     * @param string $message
     * @param string $setName
     */
    public function __construct($message, $setName, $availableSetNames)
    {
        $this->setName = $setName;
        $this->availableSetNames = $availableSetNames;
        parent::__construct($message);
    }
    public function getSetName() : string
    {
        return $this->setName;
    }
    /**
     * @return string[]
     */
    public function getAvailableSetNames() : array
    {
        return $this->availableSetNames;
    }
}
