<?php


namespace src\Utils;

class Response
{
    public static function send(int $status, string $message, mixed $data = []): void
    {
        http_response_code($status);
        
        $response = [
            'status' => $status,
            'message' => $message,
            // 'timestamp' => date('Y-m-d H:i:s'),
            // 'api_version' => Config::get('api_version')
        ];
        
        if ($data !== null) {
            $response['data'] = $data;
        }
        
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    public static function success(string $message, mixed $data = []): void
    {
        self::send(200, $message, $data);
    }
    
    public static function created(string $message, mixed $data = []): void
    {
        self::send(201, $message, $data);
    }
    
    public static function badRequest(string $message, mixed $data = []): void
    {
        self::send(400, $message, $data);
    }
    
    public static function unauthorized(string $message = 'Unauthorized'): void
    {
        self::send(401, $message);
    }
    
    public static function notFound(string $message = 'Resource not found'): void
    {
        self::send(404, $message);
    }
    
    public static function conflict(string $message, mixed $data = []): void
    {
        self::send(409, $message, $data);
    }
    
    public static function methodNotAllowed(string $message = 'Method not allowed'): void
    {
        self::send(405, $message);
    }
    
    public static function internalError(string $message = 'Internal server error'): void
    {
        self::send(500, $message);
    }
}


?>