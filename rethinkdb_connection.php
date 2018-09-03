<?php
// Composer
require_once 'vendor/autoload.php';
// Config
require_once 'config.php';

class ConnectionHolder {
    private static $conn;

    public static function getConnection() {
        if (!isset(ConnectionHolder::$conn) ) {
            $config = config('rethinkdb.connection');
            $structureConfig = config('rethinkdb.structure');
            try {
                ConnectionHolder::$conn = r\connect($config['host'], $config['port'], $structureConfig['db']);
            } catch (Exception $e) {
                http_response_code(500);
                error_log('RethinkDB Connection Error: '. $e);
                die('Could not connect to RethinkDB, check server logs');
            }
        }
        return ConnectionHolder::$conn;
    }
}

function getConnection() {
    return ConnectionHolder::getConnection();
}

function getTable() {
    return r\table(config('rethinkdb.structure.table'));
}

function getServerData($id) {
    return getTable()
        ->get($id)
        ->run(getConnection());
}

function updateServerData($data) {
    return getTable()
        ->insert($data, array(
            /* OPTIONS */
            'return_changes' => 'always',
            'conflict' => 'update'
        ))
        ->run(getConnection());
}