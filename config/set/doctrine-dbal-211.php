<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecations-in-the-wrapper-connection-class
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Connection', 'executeUpdate', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Connection', 'exec', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Connection', 'query', 'executeQuery'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#driverexceptiongeterrorcode-is-deprecated
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getSQLState'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-expressionbuilder-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'andX', 'and'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'orX', 'or'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-compositeexpression-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'add', 'with'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'addMultiple', 'with'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-fetchmode-and-the-corresponding-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Connection', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Connection', 'fetchArray', 'fetchNumeric'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Connection', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Connection', 'fetchAll', 'fetchAllAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Statement', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Statement', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Doctrine\\DBAL\\Statement', 'fetchAll', 'fetchAllAssociative'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#pdo-related-classes-outside-of-the-pdo-namespace-are-deprecated
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDO\\MySQL\\Driver',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDOOracle\\Driver' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDO\\OCI\\Driver',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDOPgSql\\Driver' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDO\\PgSQL\\Driver',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDOSqlite\\Driver' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDO\\SQLite\\Driver',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Driver' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Driver',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Connection' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Connection',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Statement' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-dbalexception
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\DBALException' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Exception',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#inconsistently-and-ambiguously-named-driver-level-classes-are-deprecated
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\DriverException' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\Exception',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\AbstractDriverException' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\AbstractException',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Driver' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\IBMDB2\\Driver',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Connection' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\IBMDB2\\Connection',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Statement' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\IBMDB2\\Statement',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliConnection' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\Mysqli\\Connection',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliStatement' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\Mysqli\\Statement',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Connection' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\OCI8\\Connection',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Statement' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\OCI8\\Statement',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvConnection' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\SQLSrv\\Connection',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvStatement' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\SQLSrv\\Statement',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDOConnection' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDO\\Connection',
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDOStatement' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Driver\\PDO\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-masterslaveconnection-use-primaryreadreplicaconnection
        'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Connections\\MasterSlaveConnection' => 'RectorPrefix2020DecSat\\Doctrine\\DBAL\\Connections\\PrimaryReadReplicaConnection',
    ]]]);
};
