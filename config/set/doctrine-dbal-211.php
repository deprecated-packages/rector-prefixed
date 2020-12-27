<?php

declare (strict_types=1);
namespace RectorPrefix20201227;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecations-in-the-wrapper-connection-class
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Connection', 'executeUpdate', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Connection', 'exec', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Connection', 'query', 'executeQuery'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#driverexceptiongeterrorcode-is-deprecated
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getSQLState'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-expressionbuilder-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'andX', 'and'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'orX', 'or'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-compositeexpression-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'add', 'with'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'addMultiple', 'with'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-fetchmode-and-the-corresponding-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Connection', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Connection', 'fetchArray', 'fetchNumeric'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Connection', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Connection', 'fetchAll', 'fetchAllAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Statement', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Statement', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Doctrine\\DBAL\\Statement', 'fetchAll', 'fetchAllAssociative'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#pdo-related-classes-outside-of-the-pdo-namespace-are-deprecated
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDO\\MySQL\\Driver',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDOOracle\\Driver' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDO\\OCI\\Driver',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDOPgSql\\Driver' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDO\\PgSQL\\Driver',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDOSqlite\\Driver' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDO\\SQLite\\Driver',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Driver' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Driver',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Connection' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Connection',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Statement' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-dbalexception
        'RectorPrefix20201227\\Doctrine\\DBAL\\DBALException' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Exception',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#inconsistently-and-ambiguously-named-driver-level-classes-are-deprecated
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\DriverException' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\Exception',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\AbstractDriverException' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\AbstractException',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Driver' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\IBMDB2\\Driver',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Connection' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\IBMDB2\\Connection',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Statement' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\IBMDB2\\Statement',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliConnection' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\Mysqli\\Connection',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliStatement' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\Mysqli\\Statement',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Connection' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\OCI8\\Connection',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Statement' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\OCI8\\Statement',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvConnection' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\SQLSrv\\Connection',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvStatement' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\SQLSrv\\Statement',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDOConnection' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDO\\Connection',
        'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDOStatement' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Driver\\PDO\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-masterslaveconnection-use-primaryreadreplicaconnection
        'RectorPrefix20201227\\Doctrine\\DBAL\\Connections\\MasterSlaveConnection' => 'RectorPrefix20201227\\Doctrine\\DBAL\\Connections\\PrimaryReadReplicaConnection',
    ]]]);
};
