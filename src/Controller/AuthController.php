<?php
namespace src\Controller;

use src\Services\AuthService;
use src\Utils\Response;
use src\Utils\JwtHelper;
use Firebase\JWT\ExpiredException;
use Throwable;

class AuthController{
    private AuthService $authService;
    private JwtHelper $jwtHelper;
    public function __construct()
    {
        $this->authService=new AuthService();
        $this->jwtHelper=new JwtHelper();
    }

    public function authLogin(){
        try{
        $body=json_decode(file_get_contents('php://input'),true)?? [];
        $result=$this->authService->authLogin($body);
        Response::send(200,'User Login Successfully',$result);
        }
        catch(Throwable $e){
            die($e->getMessage());
        }
    }
    public function refresh(): void
{
    try {

        // 1. Get request headers
        $headers = getallheaders();

        // 2. Authorization header check
        $authorization = $headers['Authorization'] ?? '';

        if (empty($authorization)) {
            Response::unauthorized(
                'Authorization header required'
            );
            return;
        }

        // 3. Check Bearer
        if (!str_starts_with($authorization, 'Bearer ')) {
            Response::unauthorized(
                'Bearer token required'
            );
            return;
        }

        // 4. Get refresh token
        $refreshToken = substr($authorization, 7);

        if (empty($refreshToken)) {
            Response::unauthorized(
                'Refresh token required'
            );
            return;
        }

        // 5. Verify / decode refresh token
        $decoded = $this->jwtHelper
    ->decodeRefreshToken(
        $refreshToken
    );

        // 6. Check token type
        if (
            !isset($decoded->type) ||
            $decoded->type !== 'refresh'
        ) {
            Response::unauthorized(
                'Invalid refresh token'
            );
            return;
        }

        // 7. Get user ID
        $userId = $decoded->user_id;

        // 8. Generate new access token
        $accessToken = $this->jwtHelper->generateAccessToken([
            'id' => $userId
        ]);
        // echo("helllo");

        // 9. Return new access token
        Response::success(
            'Access token refreshed successfully',
            [
                'access_token' => $accessToken
            ]
        );

    } catch (\Throwable $e) {
    exit();
    http_response_code(401);

echo json_encode([
    "status" => 401,
    "message" => "Signature verification failed",
    "data" => []
]);
exit;
    Response::unauthorized(
        $e->getMessage()
    );
}
 
}
}

?>