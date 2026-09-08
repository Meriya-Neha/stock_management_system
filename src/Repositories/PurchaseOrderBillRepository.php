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
        try{
            $query = "INSERT INTO purchase_orders_bill
            
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
                payment_date
                ,notes,
                total_taxable_value,
                total_cgst,
                total_sgst,
                total_igst,
                grand_total
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
                :grand_total
            )";
                
          
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':supplier_id' => $data['supplier_id'],
                ':invoice_no' => $data['invoice_no'],
                ':bill_image' => $data['bill_image'] ?? null,
                ':total_quantity' => $data['total_quantity'],
                ':total_price' => $data['total_price'],
                ':bill_date' => $data['bill_date'],
                ':remain_amount' => $data['remain_amount'],
                ':payment_mode' => $data['payment_mode'],
                ':transaction_ref_no' => $data['transaction_ref_no'],
                ':payment_date' => $data['payment_date'],
                ':notes' => $data['notes'],
                ':total_taxable_value' => $data['total_taxable_value'],
                ':total_cgst' => $data['total_cgst'],
                ':total_sgst' => $data['total_sgst'],
                ':total_igst' => $data['total_igst'],
                ':grand_total' => $data['grand_total']
            ]);
            return true;

        }
        catch(\Throwable $e){
            throw new \Exception("Failed to create purchase order bill: " . $e->getMessage());
        }
    }
}
?>