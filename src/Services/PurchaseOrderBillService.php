<?php

namespace src\Services;

use src\Repositories\PurchaseOrderBillRepository;
use src\validation\validation;

class PurchaseOrderBillService
{
    private PurchaseOrderBillRepository $purchaseOrderBillRepository;
    private validation $validation;

    public function __construct()
    {

        $this->purchaseOrderBillRepository =
            new PurchaseOrderBillRepository();
    }

    // public function createPurchaseOrderBill(
    //     array $data,
    //     ?array $file
    // ) {
    //     try {

    //         $documentPath = null;

    //         // File upload
    //         if (
    //             $file &&
    //             $file['error'] === UPLOAD_ERR_OK
    //         ) {

    //             $documentPath = $this->uploadFile($file);
    //         }

    //         // DB me path store karne ke liye
    //         $data['document'] = $documentPath;

    //         // Repository
    //         return $this->purchaseOrderBillRepository
    //             ->createPurchaseOrderBill($data);

    //     } catch (\Throwable $e) {

    //         throw $e;
    //     }
    // }

    public function createPurchaseOrderBill(
        array $data,
        ?array $file
    ) {
        try {

            $billImagePath = null;

            if (
                $file &&
                $file['error'] === UPLOAD_ERR_OK
            ) {
                $billImagePath = $this->uploadFile($file);
            }

            // DB me image ka path
            $data['bill_image'] = $billImagePath;
            $validation=$this->validation->Pobill($data);
            $result= $this->purchaseOrderBillRepository
                ->createPurchaseOrderBill($data);

            return $result;
        } catch (\Throwable $e) {

            throw $e;
        }
    }
   private function uploadFile(array $file): string
{
    // 1. Maximum file size = 5MB
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new \Exception(
            'File size must be less than 5MB'
        );
    }

    // 2. Allowed MIME types
    $allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'application/pdf'
    ];

    // 3. Detect actual MIME type
    $finfo = new \finfo(FILEINFO_MIME_TYPE);

    $mimeType = $finfo->file(
        $file['tmp_name']
    );

    // 4. Validate MIME type
    if (!in_array($mimeType, $allowedTypes, true)) {
        throw new \Exception(
            'Invalid file type'
        );
    }

    // 5. Upload directory
    $uploadDirectory =
        __DIR__ . '/../uploads/purchase-order-bill/';

    if (!is_dir($uploadDirectory)) {
        mkdir(
            $uploadDirectory,
            0755,
            true
        );
    }

    // 6. Generate random filename
    $fileName =
        bin2hex(random_bytes(16));

    /*
     * 7. If image
     *    Convert image to WebP
     */
    if (str_starts_with($mimeType, 'image/')) {

        $destination =
            $uploadDirectory . $fileName . '.webp';

        switch ($mimeType) {

            case 'image/jpeg':
                $image = imagecreatefromjpeg(
                    $file['tmp_name']
                );
                break;

            case 'image/png':
                $image = imagecreatefrompng(
                    $file['tmp_name']
                );

                // Preserve PNG transparency
                imagepalettetotruecolor($image);
                imagealphablending($image, false);
                imagesavealpha($image, true);

                break;

            case 'image/webp':
                $image = imagecreatefromwebp(
                    $file['tmp_name']
                );
                break;

            default:
                throw new \Exception(
                    'Unsupported image type'
                );
        }

        if (!$image) {
            throw new \Exception(
                'Failed to create image'
            );
        }

        // Convert and save as WebP
        if (!imagewebp(
            $image,
            $destination,
            80
        )) {
            imagedestroy($image);

            throw new \Exception(
                'Failed to convert image to WebP'
            );
        }

        // Free memory
        imagedestroy($image);

        return 'uploads/purchase-order-bill/'
            . $fileName
            . '.webp';
    }

    /*
     * 8. PDF
     *    Save PDF without conversion
     */
    $destination =
        $uploadDirectory . $fileName . '.pdf';

    if (!move_uploaded_file(
        $file['tmp_name'],
        $destination
    )) {
        throw new \Exception(
            'Failed to upload file'
        );
    }

    return 'uploads/purchase-order-bill/'
        . $fileName
        . '.pdf';
}

 // GET ALL
    public function getAll(): array
    {
        return $this->purchaseOrderBillRepository->getAll();
    }

    // GET BY ID
    public function getById(int $id): array
    {
        if ($id <= 0) {
            throw new \Exception('Invalid purchase order bill ID');
        }

        $bill = $this->purchaseOrderBillRepository->getById($id);

        if (!$bill) {
            throw new \Exception('Purchase order bill not found');
        }

        return $bill;
    }

    // UPDATE
    public function update(int $id, array $data): array
    {
        // Check record exists
        $this->getById($id);

        if (empty($data['supplier_id'])) {
            throw new \Exception('supplier_id is required');
        }

        if (empty($data['invoice_no'])) {
            throw new \Exception('invoice_no is required');
        }

        if (!isset($data['total_quantity']) || $data['total_quantity'] <= 0) {
            throw new \Exception('total_quantity must be greater than 0');
        }

        if (!isset($data['total_price']) || $data['total_price'] < 0) {
            throw new \Exception('total_price is required');
        }

        if (empty($data['bill_date'])) {
            throw new \Exception('bill_date is required');
        }

        if (!isset($data['remain_amount']) || $data['remain_amount'] < 0) {
            throw new \Exception('remain_amount is required');
        }

        if (empty($data['payment_mode'])) {
            throw new \Exception('payment_mode is required');
        }

        if (!isset($data['total_taxable_value'])) {
            throw new \Exception('total_taxable_value is required');
        }

        if (!isset($data['total_cgst'])) {
            throw new \Exception('total_cgst is required');
        }

        if (!isset($data['total_sgst'])) {
            throw new \Exception('total_sgst is required');
        }

        if (!isset($data['total_igst'])) {
            throw new \Exception('total_igst is required');
        }

        if (!isset($data['grand_total'])) {
            throw new \Exception('grand_total is required');
        }

        if (!isset($data['gst_rate'])) {
            throw new \Exception('gst_rate is required');
        }

        return $this->purchaseOrderBillRepository->update($id, $data);
    }

    // DELETE
    public function delete(int $id): void
    {
        // Check record exists
        $this->getById($id);

        $deleted = $this->purchaseOrderBillRepository->delete($id);

        if (!$deleted) {
            throw new \Exception('Failed to delete purchase order bill');
        }
    }
}
