<?php
require '../vendor/autoload.php';
mb_internal_encoding('UTF-8');

$envFile = '.env';

if (isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] === 'test') {
    $envFile = '.env.test';
}

try{
    $dotenv = Dotenv\Dotenv::createImmutable('../');
    $dotenv->load();
    Com\Daw2\Core\FrontController::main();    
} catch (Exception $e) {
    if($_ENV['folder.views']){
        throw $e;
    }
    else{
        echo $e->getMessage();
    }
}
