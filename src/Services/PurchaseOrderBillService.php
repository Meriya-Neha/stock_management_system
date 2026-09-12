<?php

namespace src\Services;

use src\Repositories\PurchaseOrderBillRepository;

class PurchaseOrderBillService
{
    private PurchaseOrderBillRepository $purchaseOrderBillRepository;

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

            return $this->purchaseOrderBillRepository
                ->createPurchaseOrderBill($data);
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
}
