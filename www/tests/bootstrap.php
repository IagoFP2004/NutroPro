<?php

declare(strict_types=1);

// Cargar el autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno para testing
$envFile = '.env';
if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'test') {
    $envFile = '.env.test';
}
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..', $envFile);
$dotenv->load();

// Configurar variables de entorno adicionales para testing
$_ENV['numero.pagina'] = 10;

// Configurar sesión para testing
if (!isset($_SESSION)) {
    $_SESSION = [];
}

// Función helper para limpiar la sesión entre tests
function cleanSession(): void
{
    $_SESSION = [];
}

// Función helper para crear una conexión PDO mock
function createMockPDO(): PDO
{
    $pdo = $this->createMock(PDO::class);

    // Configurar comportamiento básico del mock
    $pdo->method('prepare')
        ->willReturn($this->createMock(PDOStatement::class));

    return $pdo;
}

