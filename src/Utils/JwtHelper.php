<?php

namespace src\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
     private string $algorithm;

    public function __construct()
    {
        $this->algorithm = $_ENV['JWT_ALGORITHM'];
    }

    // Access Token
    public function generateAccessToken(array $user): string
    {
        $issuedAt = time();
        $expireAt = $issuedAt + (int) $_ENV['ACCESS_TOKEN_EXPIRY'];

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expireAt,
            'type' => 'access',
            'user_id' => $user['id']
        ];

        return JWT::encode(
            $payload,
            $_ENV['jwt_access'],
            $this->algorithm
        );
    }

    // Refresh Token
    public function generateRefreshToken(array $user): string
    {
        $issuedAt = time();
        $expireAt = $issuedAt + (int) $_ENV['REFRESH_TOKEN_EXPIRY'];

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expireAt,
            'type' => 'refresh',
            'user_id' => $user['id']
        ];

        return JWT::encode(
            $payload,
            $_ENV['jwt_refresh'],
            $this->algorithm
        );
    }

    // Access Token Decode
    public function decodeAccessToken(string $token): object
    {
        return JWT::decode(
            $token,
            new Key(
                $_ENV['jwt_access'],
                $this->algorithm
            )
        );
    }

    // Refresh Token Decode
    public function decodeRefreshToken(string $token): object
    {
        return JWT::decode(
            $token,
            new Key(
                $_ENV['jwt_refresh'],
                $this->algorithm
            )
        );
    }
    public function check(): object
{
    $headers = getallheaders();

    $authorization = $headers['Authorization'] ?? '';

    $token = substr($authorization, 7);

    return $this->decodeAccessToken($token);
}
}