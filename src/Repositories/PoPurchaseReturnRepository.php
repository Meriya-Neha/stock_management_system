<?php
namespace src\Repositories;
use src\config\Database;
use PDO;

class PoPurchaseReturnRepository{
    private \PDO $db;

    public function __construct()
    {
        $this->db=Database::getConnection();
    }
    public function createPurchaseReturn(array $data)
{
    $sql = "INSERT INTO po_purchase_return
            (
                purchase_order_id,
                quantity,
                purchase_price,
                return_reason_id,
                return_amount,
                payment_mode,
                remain_amount,
                transaction_ref_no,
                payment_date,
                notes
            )
            VALUES
            (
                :purchase_order_id,
                :quantity,
                :purchase_price,
                :return_reason_id,
                :return_amount,
                :payment_mode,
                :remain_amount,
                :transaction_ref_no,
                :payment_date,
                :notes
            )";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':purchase_order_id' => $data['purchase_order_id'],
        ':quantity' => $data['quantity'],
        ':purchase_price' => $data['purchase_price'],
        ':return_reason_id' => $data['return_reason_id'],
        ':return_amount' => $data['return_amount'],
        ':payment_mode' => $data['payment_mode'] ?? null,
        ':remain_amount' => $data['remain_amount'] ?? 0,
        ':transaction_ref_no' => $data['transaction_ref_no'] ?? null,
        ':payment_date' => $data['payment_date'] ?? null,
        ':notes' => $data['notes'] ?? null
    ]);

    $id = $this->db->lastInsertId();

    return [
        "id" => $id,
        "purchase_order_id" => $data['purchase_order_id'],
        "quantity" => $data['quantity'],
        "return_amount" => $data['return_amount']
    ];
}
public function getAll(): array
{
    $sql = "SELECT
                
                purchase_order_id,
                quantity,
                purchase_price,
                return_reason_id,
                return_amount,
                payment_mode,
                remain_amount,
                transaction_ref_no,
                payment_date,
                notes,
                created_at
            FROM po_purchase_return
            ORDER BY id DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getById(int $id): ?array
{
    $sql = "SELECT
                id,
                purchase_order_id,
                quantity,
                purchase_price,
                return_reason_id,
                return_amount,
                payment_mode,
                remain_amount,
                transaction_ref_no,
                payment_date,
                notes,
                created_at
            FROM po_purchase_return
            WHERE id = :id";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ?: null;
}
}

?>