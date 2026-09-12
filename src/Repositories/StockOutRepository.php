<?php

namespace src\Repositories;

use PDO;
use src\config\Database;

class StockOutRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // CREATE
    public function create(array $data): array
    {
        $sql = "INSERT INTO purchase_stock_out
                (
                    purchase_order_id,
                    uom_id,
                    quantity,
                    stock_out_date,
                    created_at
                )
                VALUES
                (
                    :purchase_order_id,
                    :uom_id,
                    :quantity,
                    :stock_out_date,
                    NOW()
                )";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':purchase_order_id' => $data['purchase_order_id'],
            ':uom_id' => $data['uom_id'],
            ':quantity' => $data['quantity'],
            ':stock_out_date' => $data['stock_out_date']
        ]);

        $id = (int) $this->db->lastInsertId();

        return $this->getById($id);
    }


    // GET ALL
    public function getAll(): array
    {
        $sql = "SELECT
                    id,
                    purchase_order_id,
                    uom_id,
                    quantity,
                    stock_out_date,
                    created_at
                FROM purchase_stock_out
                ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // GET BY ID
    public function getById(int $id): ?array
    {
        $sql = "SELECT
                    id,
                    purchase_order_id,
                    uom_id,
                    quantity,
                    stock_out_date,
                    created_at
                FROM purchase_stock_out
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }


    // UPDATE
    public function update(int $id, array $data): ?array
    {
        $sql = "UPDATE purchase_stock_out
                SET
                    purchase_order_id = :purchase_order_id,
                    uom_id = :uom_id,
                    quantity = :quantity,
                    stock_out_date = :stock_out_date
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':purchase_order_id' => $data['purchase_order_id'],
            ':uom_id' => $data['uom_id'],
            ':quantity' => $data['quantity'],
            ':stock_out_date' => $data['stock_out_date'],
            ':id' => $id
        ]);

        return $this->getById($id);
    }


    // DELETE
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM purchase_stock_out
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->rowCount() > 0;
    }
}