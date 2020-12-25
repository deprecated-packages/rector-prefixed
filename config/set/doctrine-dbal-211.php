<?php

declare (strict_types=1);
namespace _PhpScoper5b8c9e9ebd21;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecations-in-the-wrapper-connection-class
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Connection', 'executeUpdate', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Connection', 'exec', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Connection', 'query', 'executeQuery'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#driverexceptiongeterrorcode-is-deprecated
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getSQLState'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-expressionbuilder-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'andX', 'and'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'orX', 'or'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-compositeexpression-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'add', 'with'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'addMultiple', 'with'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-fetchmode-and-the-corresponding-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Connection', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Connection', 'fetchArray', 'fetchNumeric'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Connection', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Connection', 'fetchAll', 'fetchAllAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Statement', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Statement', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Statement', 'fetchAll', 'fetchAllAssociative'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#pdo-related-classes-outside-of-the-pdo-namespace-are-deprecated
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDO\\MySQL\\Driver',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDOOracle\\Driver' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDO\\OCI\\Driver',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDOPgSql\\Driver' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDO\\PgSQL\\Driver',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDOSqlite\\Driver' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDO\\SQLite\\Driver',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Driver' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Driver',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Connection' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Connection',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Statement' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-dbalexception
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\DBALException' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Exception',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#inconsistently-and-ambiguously-named-driver-level-classes-are-deprecated
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\DriverException' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\Exception',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\AbstractDriverException' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\AbstractException',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Driver' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\IBMDB2\\Driver',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Connection' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\IBMDB2\\Connection',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Statement' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\IBMDB2\\Statement',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliConnection' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\Mysqli\\Connection',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliStatement' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\Mysqli\\Statement',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Connection' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\OCI8\\Connection',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Statement' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\OCI8\\Statement',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvConnection' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\SQLSrv\\Connection',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvStatement' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\SQLSrv\\Statement',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDOConnection' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDO\\Connection',
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDOStatement' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Driver\\PDO\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-masterslaveconnection-use-primaryreadreplicaconnection
        '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Connections\\MasterSlaveConnection' => '_PhpScoper5b8c9e9ebd21\\Doctrine\\DBAL\\Connections\\PrimaryReadReplicaConnection',
    ]]]);
};
