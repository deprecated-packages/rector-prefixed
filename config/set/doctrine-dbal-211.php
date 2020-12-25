<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecations-in-the-wrapper-connection-class
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Connection', 'executeUpdate', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Connection', 'exec', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Connection', 'query', 'executeQuery'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#driverexceptiongeterrorcode-is-deprecated
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getSQLState'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-expressionbuilder-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'andX', 'and'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'orX', 'or'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-compositeexpression-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'add', 'with'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'addMultiple', 'with'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-fetchmode-and-the-corresponding-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Connection', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Connection', 'fetchArray', 'fetchNumeric'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Connection', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Connection', 'fetchAll', 'fetchAllAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Statement', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Statement', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Statement', 'fetchAll', 'fetchAllAssociative'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#pdo-related-classes-outside-of-the-pdo-namespace-are-deprecated
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDO\\MySQL\\Driver',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDOOracle\\Driver' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDO\\OCI\\Driver',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDOPgSql\\Driver' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDO\\PgSQL\\Driver',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDOSqlite\\Driver' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDO\\SQLite\\Driver',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Driver' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Driver',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Connection' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Connection',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Statement' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-dbalexception
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\DBALException' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Exception',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#inconsistently-and-ambiguously-named-driver-level-classes-are-deprecated
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\DriverException' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\Exception',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\AbstractDriverException' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\AbstractException',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Driver' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\IBMDB2\\Driver',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Connection' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\IBMDB2\\Connection',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Statement' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\IBMDB2\\Statement',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliConnection' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\Mysqli\\Connection',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliStatement' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\Mysqli\\Statement',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Connection' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\OCI8\\Connection',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Statement' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\OCI8\\Statement',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvConnection' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\SQLSrv\\Connection',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvStatement' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\SQLSrv\\Statement',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDOConnection' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDO\\Connection',
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDOStatement' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Driver\\PDO\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-masterslaveconnection-use-primaryreadreplicaconnection
        '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Connections\\MasterSlaveConnection' => '_PhpScoperfce0de0de1ce\\Doctrine\\DBAL\\Connections\\PrimaryReadReplicaConnection',
    ]]]);
};
