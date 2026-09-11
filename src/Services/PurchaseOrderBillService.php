<?php
namespace src\Services;
use src\Repositories\PurchaseOrderBillRepository;

class PurchaseOrderBillService
{
    private PurchaseOrderBillRepository $purchaseOrderBillRepository;
    private string $uploadDir; 

    public function __construct()
    {
        $this->purchaseOrderBillRepository = new PurchaseOrderBillRepository();
        $this->uploadDir = rtrim(__DIR__ . '/../../uploads', DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function createPurchaseOrderBill(array $data,?array $file)
    {   
        print_r($data);
        try{
            // $result = $this->purchaseOrderBillRepository->createPurchaseOrderBill($data);
            $documentPath = null;

        // 2. File Upload Handling Logic
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $documentPath = $this->uploadFile($file);
        }

        // 3. Delegate DB Save to Repository
        return $this->purchaseOrderBillRepository->createPurchaseOrderBill([
            'data' => $data,
            'document_path' => $documentPath,
        ]);
            return $result;
        }
        catch(\Throwable $e){
            throw new \Exception("Failed to create purchase order bill: " . $e->getMessage());
        }
       
    }
    private function uploadFile(array $file): string
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'application/pdf' => 'pdf'];
        if (!array_key_exists($mime, $allowed)) {
            throw new \InvalidArgumentException('Invalid file type uploaded.');
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
        $destination = $this->uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new \RuntimeException('Failed to save uploaded file.');
        }

        return $filename;
    }

}

?>