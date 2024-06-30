<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    private static PDO $pdo;

    public function __construct(
        string $db,
        string $user,
        string $host,
        string $password
    ) {
        $dsn = "mysql:host={$host};dbname={$db};user={$user};password={$password}";
        static::$pdo = new PDO($dsn);
    }

    public static function getConnection(): PDO
    {
        return static::$pdo;
    }
}
