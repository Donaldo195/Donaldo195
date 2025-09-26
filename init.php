<?php
// Inicia a sessão
session_start();

// Configurações globais
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'dona',
        'password' => 'donaldo',
        'db' => 'exame' 
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user'
    )
);

// Autoload das classes (controllers, core, models)
spl_autoload_register(function($class) {
    $paths = ['controller/', 'core/', 'models/'];
    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once __DIR__ . '/config/conexao.php'; 
