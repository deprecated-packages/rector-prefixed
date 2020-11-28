<?php

namespace _PhpScoperabd03f0baf05;

interface SessionUpdateTimestampHandlerInterface
{
    /** @return bool */
    public function validateId(string $id);
    /** @return bool */
    public function updateTimestamp(string $id, string $data);
}
\class_alias('_PhpScoperabd03f0baf05\\SessionUpdateTimestampHandlerInterface', 'SessionUpdateTimestampHandlerInterface', \false);
