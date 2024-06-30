<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;
use App\Database;

class ProductRepository
{
    public function __construct(
        private Database $database,
    ) {
    }

    public function getAll(): array
    {
        $pdo = $this->database::getConnection();

        $stmt = $pdo->query('SELECT * FROM product');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): bool|array
    {
        $pdo = $this->database::getConnection();

        $stmt = $pdo->prepare('SELECT * FROM product WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
