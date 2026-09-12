<?php

namespace src\Repositories;

use PDO;
use src\config\Database;
class PoOrderItemRepository
{
    private \PDO $db;

    public function __construct()
    {

        $this->db = Database::getConnection();
    }

    public function create(array $data): array
    {
        $sql = "
            INSERT INTO purchase_order_items
            (
                purchase_order_bill_id,
                product_name,
                product_main_category_id,
                item_location_id,
                uom_id,
                quantity,
                purchase_price,
                total_price,
                purchase_date
            )
            VALUES
            (
                :purchase_order_bill_id,
                :product_name,
                :product_main_category_id,
                :item_location_id,
                :uom_id,
                :quantity,
                :purchase_price,
                :total_price,
                :purchase_date
            )
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':purchase_order_bill_id' =>
                $data['purchase_order_bill_id'],

            ':product_name' =>
                $data['product_name'],

            ':product_main_category_id' =>
                $data['product_main_category_id'],

            ':item_location_id' =>
                $data['item_location_id'],

            ':uom_id' =>
                $data['uom_id'],

            ':quantity' =>
                $data['quantity'],

            ':purchase_price' =>
                $data['purchase_price'],

            ':total_price' =>
                $data['total_price'],

            ':purchase_date' =>
                $data['purchase_date']
        ]);

        $id = (int)$this->db->lastInsertId();

        return [
            'id' => $id,
            'purchase_order_bill_id' => $data['purchase_order_bill_id'],
            'product_name' => $data['product_name'],
            'product_main_category_id' => $data['product_main_category_id'],
            'item_location_id' => $data['item_location_id'],
            'uom_id' => $data['uom_id'],
            'quantity' => $data['quantity'],
            'purchase_price' => $data['purchase_price'],
            'total_price' => $data['total_price'],
            'purchase_date' => $data['purchase_date']
        ];
    }
     // GET ALL
    public function getAll(): array
    {
        $sql = "SELECT
                    id,
                    purchase_order_bill_id,
                    product_name,
                    product_main_category_id,
                    item_location_id,
                    uom_id,
                    quantity,
                    purchase_price,
                    total_price,
                    purchase_date
                FROM purchase_order_items
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
                    purchase_order_bill_id,
                    product_name,
                    product_main_category_id,
                    item_location_id,
                    uom_id,
                    quantity,
                    purchase_price,
                    total_price,
                    purchase_date
                FROM purchase_order_items
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
        $sql = "UPDATE purchase_order_items
                SET
                    purchase_order_bill_id = :purchase_order_bill_id,
                    product_name = :product_name,
                    product_main_category_id = :product_main_category_id,
                    item_location_id = :item_location_id,
                    uom_id = :uom_id,
                    quantity = :quantity,
                    purchase_price = :purchase_price,
                    total_price = :total_price,
                    purchase_date = :purchase_date
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':purchase_order_bill_id' => $data['purchase_order_bill_id'],
            ':product_name' => $data['product_name'],
            ':product_main_category_id' => $data['product_main_category_id'],
            ':item_location_id' => $data['item_location_id'],
            ':uom_id' => $data['uom_id'],
            ':quantity' => $data['quantity'],
            ':purchase_price' => $data['purchase_price'],
            ':total_price' => $data['total_price'],
            ':purchase_date' => $data['purchase_date'],
            ':id' => $id
        ]);

        return $this->getById($id);
    }

    // DELETE
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM purchase_order_items
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->rowCount() > 0;
    }
    
}