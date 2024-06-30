<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;
use App\Database;

class ProductRepository
{
    private PDO $connection;

    public function __construct(
        private Database $database,
    ) {
        $this->connection = database::getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->connection->query('SELECT * FROM product');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): bool|array
    {
        $stmt = $this->connection->prepare('SELECT * FROM product WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): ?string
    {
        $query = 'INSERT INTO product (name, description, size) VALUES (:name, :description, :size)';
        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':size', $data['size'], PDO::PARAM_INT);
        $stmt->bindValue(
            ':description',
            $data['description'] ?: null,
            $data['description'] ? PDO::PARAM_STR : PDO::PARAM_NULL,
        );

        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $query = 'UPDATE product SET name = :name, description = :description, size = :size WHERE id = :id';
        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':size', $data['size'], PDO::PARAM_INT);
        $stmt->bindValue(
            ':description',
            $data['description'] ?: null,
            $data['description'] ? PDO::PARAM_STR : PDO::PARAM_NULL,
        );

        $stmt->execute();

        return (bool) $stmt->rowCount();
    }

    public function delete(string $id): bool
    {
        $query = 'DELETE FROM product WHERE id = :id';
        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return (bool) $stmt->rowCount();
    }
}
