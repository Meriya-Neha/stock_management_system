<?php

namespace src\Repositories;

use PDO;
use src\config\Database;

class PoCompanyLossesRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // CREATE
    public function create(array $data): array
    {
        $sql = "INSERT INTO po_company_losses
                (
                    purchase_order_item_id,
                    loss_quantity,
                    loss_amount,
                    created_at
                )
                VALUES
                (
                    :purchase_order_item_id,
                    :loss_quantity,
                    :loss_amount,
                    NOW()
                )";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':purchase_order_item_id' => $data['purchase_order_item_id'],
            ':loss_quantity' => $data['loss_quantity'],
            ':loss_amount' => $data['loss_amount']
        ]);

        $id = (int) $this->db->lastInsertId();

        return $this->getById($id);
    }


    // GET ALL
    public function getAll(): array
    {
        $sql = "SELECT
                    id,
                    purchase_order_item_id,
                    loss_quantity,
                    loss_amount,
                    created_at
                FROM po_company_losses
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
                    purchase_order_item_id,
                    loss_quantity,
                    loss_amount,
                    created_at
                FROM po_company_losses
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
        $sql = "UPDATE po_company_losses
                SET
                    purchase_order_item_id = :purchase_order_item_id,
                    loss_quantity = :loss_quantity,
                    loss_amount = :loss_amount
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':purchase_order_item_id' => $data['purchase_order_item_id'],
            ':loss_quantity' => $data['loss_quantity'],
            ':loss_amount' => $data['loss_amount'],
            ':id' => $id
        ]);

        return $this->getById($id);
    }


    // DELETE
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM po_company_losses
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->rowCount() > 0;
    }
}