<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecations-in-the-wrapper-connection-class
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Connection', 'executeUpdate', 'executeStatement'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Connection', 'exec', 'executeStatement'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Connection', 'query', 'executeQuery'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#driverexceptiongeterrorcode-is-deprecated
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getSQLState'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-expressionbuilder-methods
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'andX', 'and'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'orX', 'or'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-compositeexpression-methods
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'add', 'with'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'addMultiple', 'with'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-fetchmode-and-the-corresponding-methods
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Connection', 'fetchAssoc', 'fetchAssociative'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Connection', 'fetchArray', 'fetchNumeric'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Connection', 'fetchColumn', 'fetchOne'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Connection', 'fetchAll', 'fetchAllAssociative'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Statement', 'fetchAssoc', 'fetchAssociative'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Statement', 'fetchColumn', 'fetchOne'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Statement', 'fetchAll', 'fetchAllAssociative'),
    ])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#pdo-related-classes-outside-of-the-pdo-namespace-are-deprecated
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDO\\MySQL\\Driver',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDOOracle\\Driver' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDO\\OCI\\Driver',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDOPgSql\\Driver' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDO\\PgSQL\\Driver',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDOSqlite\\Driver' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDO\\SQLite\\Driver',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Driver' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Driver',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Connection' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Connection',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Statement' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-dbalexception
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\DBALException' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Exception',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#inconsistently-and-ambiguously-named-driver-level-classes-are-deprecated
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\DriverException' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\Exception',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\AbstractDriverException' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\AbstractException',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Driver' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\IBMDB2\\Driver',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Connection' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\IBMDB2\\Connection',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Statement' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\IBMDB2\\Statement',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliConnection' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\Mysqli\\Connection',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliStatement' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\Mysqli\\Statement',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Connection' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\OCI8\\Connection',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Statement' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\OCI8\\Statement',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvConnection' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\SQLSrv\\Connection',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvStatement' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\SQLSrv\\Statement',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDOConnection' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDO\\Connection',
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDOStatement' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Driver\\PDO\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-masterslaveconnection-use-primaryreadreplicaconnection
        '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Connections\\MasterSlaveConnection' => '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Connections\\PrimaryReadReplicaConnection',
    ]]]);
};
