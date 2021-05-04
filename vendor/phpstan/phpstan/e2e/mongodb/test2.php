<?php

declare (strict_types=1);
namespace RectorPrefix20210504;

use MongoDB\Driver\Manager;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\WriteResult;
class MongoDBE2ETest
{
    public function test() : \MongoDB\Driver\WriteResult
    {
        // connect
        $manager = new \MongoDB\Driver\Manager("mongodb://localhost:27017");
        return $manager->executeBulkWrite("collection", new \MongoDB\Driver\BulkWrite(\true));
    }
}
\class_alias('RectorPrefix20210504\\MongoDBE2ETest', 'MongoDBE2ETest', \false);
