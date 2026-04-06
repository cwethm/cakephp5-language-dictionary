<?php
declare(strict_types=1);

use Cake\Core\Configure;
use Cake\Cache\Cache;
use Cake\Datasource\ConnectionManager;

define('ROOT', dirname(__DIR__));
define('APP_DIR', 'src');
define('APP', ROOT . DS . APP_DIR . DS);
define('TMP', sys_get_temp_dir() . DS);
define('LOGS', TMP . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);
define('CAKE_CORE_INCLUDE_PATH', ROOT . '/vendor/cakephp/cakephp');
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);

require_once ROOT . '/vendor/autoload.php';
require_once CORE_PATH . 'config/bootstrap.php';

Configure::write('debug', true);
Configure::write('App', [
    'namespace' => 'LanguageDictionary',
    'encoding' => 'UTF-8',
    'base' => false,
    'baseUrl' => false,
    'dir' => APP_DIR,
    'webroot' => 'webroot',
    'wwwRoot' => ROOT . DS . 'webroot' . DS,
    'fullBaseUrl' => 'http://localhost',
    'imageBaseUrl' => 'img/',
    'cssBaseUrl' => 'css/',
    'jsBaseUrl' => 'js/',
    'paths' => [
        'plugins' => [ROOT . DS . 'plugins' . DS],
        'templates' => [ROOT . DS . 'templates' . DS],
        'locales' => [ROOT . DS . 'resources' . DS . 'locales' . DS],
    ],
]);

ConnectionManager::setConfig('test', [
    'className' => 'Cake\Database\Connection',
    'driver' => 'Cake\Database\Driver\Sqlite',
    'database' => TMP . 'test.db',
    'encoding' => 'utf8',
    'timezone' => 'UTC',
    'cacheMetadata' => false,
]);

ConnectionManager::setConfig('default', [
    'className' => 'Cake\Database\Connection',
    'driver' => 'Cake\Database\Driver\Sqlite',
    'database' => TMP . 'test.db',
    'encoding' => 'utf8',
    'timezone' => 'UTC',
    'cacheMetadata' => false,
]);

Cache::setConfig([
    '_cake_translations_' => [
        'className' => 'Cake\Cache\Engine\FileEngine',
        'prefix' => 'cake_translations_',
        'path' => TMP . 'cache' . DS . 'persistent' . DS,
        'serialize' => true,
        'duration' => '+2 minutes',
    ],
    '_cake_model_' => [
        'className' => 'Cake\Cache\Engine\FileEngine',
        'prefix' => 'cake_model_',
        'path' => TMP . 'cache' . DS . 'models' . DS,
        'serialize' => true,
        'duration' => '+2 minutes',
    ],
]);

// Create tables for testing
$connection = ConnectionManager::get('test');
$connection->execute('DROP TABLE IF EXISTS translations');
$connection->execute('DROP TABLE IF EXISTS words');
$connection->execute(
    'CREATE TABLE words (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        word VARCHAR(255) NOT NULL,
        language_code VARCHAR(10) NOT NULL,
        created DATETIME NOT NULL,
        modified DATETIME NOT NULL,
        UNIQUE (word, language_code)
    )'
);
$connection->execute(
    'CREATE TABLE translations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        word_id INTEGER NOT NULL,
        translated_word VARCHAR(255) NOT NULL,
        language_code VARCHAR(10) NOT NULL,
        created DATETIME NOT NULL,
        modified DATETIME NOT NULL,
        UNIQUE (word_id, language_code),
        FOREIGN KEY (word_id) REFERENCES words(id) ON DELETE CASCADE
    )'
);

\Cake\Core\Plugin::getCollection()->add(new \LanguageDictionary\Plugin());

