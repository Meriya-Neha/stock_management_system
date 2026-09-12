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
}