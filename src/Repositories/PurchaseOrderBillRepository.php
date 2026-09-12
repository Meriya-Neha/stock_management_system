<?php
namespace src\Repositories;
use Throwable;
use src\config\Database;
use PDO;

class PurchaseOrderBillRepository
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    public function createPurchaseOrderBill(array $data)
{
    $sql = "
        INSERT INTO purchase_orders_bill
        (
            supplier_id,
            invoice_no,
            bill_image,
            total_quantity,
            total_price,
            bill_date,
            remain_amount,
            payment_mode,
            transaction_ref_no,
            payment_date,
            notes,
            total_taxable_value,
            total_cgst,
            total_sgst,
            total_igst,
            grand_total,
            gst_rate
            
        )
        VALUES
        (
            :supplier_id,
            :invoice_no,
            :bill_image,
            :total_quantity,
            :total_price,
            :bill_date,
            :remain_amount,
            :payment_mode,
            :transaction_ref_no,
            :payment_date,
            :notes,
            :total_taxable_value,
            :total_cgst,
            :total_sgst,
            :total_igst,
            :grand_total,
            :gst_rate
            
        )
    ";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':supplier_id'         => $data['supplier_id'],
        ':invoice_no'          => $data['invoice_no'],
        ':bill_image'          => $data['bill_image'],
        ':total_quantity'      => $data['total_quantity'],
        ':total_price'         => $data['total_price'],
        ':bill_date'           => $data['bill_date'],
        ':remain_amount'       => $data['remain_amount'],
        ':payment_mode'        => $data['payment_mode'],
        ':transaction_ref_no'  => $data['transaction_ref_no'],
        ':payment_date'        => $data['payment_date'],
        ':notes'               => $data['notes'] ?? null,
        ':total_taxable_value' => $data['total_taxable_value'],
        ':total_cgst'          => $data['total_cgst'],
        ':total_sgst'          => $data['total_sgst'],
        ':total_igst'          => $data['total_igst'],
        ':grand_total'         => $data['grand_total'],
        ':gst_rate'            => $data['gst_rate'],
        // ':gst_type'            => $data['gst_type'],
        
    ]);

    return [
        'id' => (int) $this->db->lastInsertId()
    ];
}

    // GET ALL
    public function getAll(): array
    {
        $sql = "SELECT
                    id,
                    supplier_id,
                    invoice_no,
                    bill_image,
                    total_quantity,
                    total_price,
                    bill_date,
                    remain_amount,
                    payment_mode,
                    transaction_ref_no,
                    payment_date,
                    notes,
                    total_taxable_value,
                    total_cgst,
                    total_sgst,
                    total_igst,
                    grand_total,
                    gst_rate
                FROM purchase_orders_bill
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
                    supplier_id,
                    invoice_no,
                    bill_image,
                    total_quantity,
                    total_price,
                    bill_date,
                    remain_amount,
                    payment_mode,
                    transaction_ref_no,
                    payment_date,
                    notes,
                    total_taxable_value,
                    total_cgst,
                    total_sgst,
                    total_igst,
                    grand_total,
                    gst_rate
                FROM purchase_orders_bill
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
        $sql = "UPDATE purchase_orders_bill
                SET
                    supplier_id = :supplier_id,
                    invoice_no = :invoice_no,
                    bill_image = :bill_image,
                    total_quantity = :total_quantity,
                    total_price = :total_price,
                    bill_date = :bill_date,
                    remain_amount = :remain_amount,
                    payment_mode = :payment_mode,
                    transaction_ref_no = :transaction_ref_no,
                    payment_date = :payment_date,
                    notes = :notes,
                    total_taxable_value = :total_taxable_value,
                    total_cgst = :total_cgst,
                    total_sgst = :total_sgst,
                    total_igst = :total_igst,
                    grand_total = :grand_total,
                    gst_rate = :gst_rate
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':supplier_id' => $data['supplier_id'],
            ':invoice_no' => $data['invoice_no'],
            ':bill_image' => $data['bill_image'] ?? null,
            ':total_quantity' => $data['total_quantity'],
            ':total_price' => $data['total_price'],
            ':bill_date' => $data['bill_date'],
            ':remain_amount' => $data['remain_amount'],
            ':payment_mode' => $data['payment_mode'],
            ':transaction_ref_no' => $data['transaction_ref_no'] ?? null,
            ':payment_date' => $data['payment_date'] ?? null,
            ':notes' => $data['notes'] ?? null,
            ':total_taxable_value' => $data['total_taxable_value'],
            ':total_cgst' => $data['total_cgst'],
            ':total_sgst' => $data['total_sgst'],
            ':total_igst' => $data['total_igst'],
            ':grand_total' => $data['grand_total'],
            ':gst_rate' => $data['gst_rate'],
            ':id' => $id
        ]);

        return $this->getById($id);
    }

    // DELETE
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM purchase_orders_bill
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->rowCount() > 0;
    }
}
?>