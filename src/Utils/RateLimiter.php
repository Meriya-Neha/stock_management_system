<?php
namespace src\Utils;

use src\config\Database;
use Throwable;

class RateLimiter
{
   

    private const DEFAULT_LIMIT = [
        'window' => 60,
        'max_hits' => 100
    ];

    private const LIMITS = [
        '/auth/login' => [
            'window' => 60,
            'max_hits' => 5
        ],

        '/auth/refresh_token' => [
            'window' => 60,
            'max_hits' => 10
        ],

        '/auth/forgot_password' => [
            'window' => 60,
            'max_hits' => 3
        ],
    ];

    public static function check(
        string $endpoint,
        ?string $username = null
    ): void {

        // Endpoint ke according limit nikalo
        $config = self::LIMITS[$endpoint] ?? self::DEFAULT_LIMIT;

        $windowSeconds = $config['window'];
        $maxHits = $config['max_hits'];

        // Client IP
        $ip = self::clientIp();

        // IP + username ko identifier banayenge
        if ($username !== null && trim($username) !== '') {

            $username = strtolower(trim($username));

            $identifier = $ip . '|' . $username;

        } else {

            $identifier = $ip;
        }

        // Current time
        $currentTimestamp = time();

        // Current fixed window ka starting timestamp
        $windowStartTimestamp =
            $currentTimestamp -
            ($currentTimestamp % $windowSeconds);

        // DATETIME format
        $windowStart = date(
            'Y-m-d H:i:s',
            $windowStartTimestamp
        );

        try {

            Database::begin();
            Database::exec("INSERT INTO rate_limits(identifier,endpoint, hits, window_start )VALUES(:identifier, :endpoint,1, :window_start)
                    ON DUPLICATE KEY UPDATE
                    hits = IF(window_start = :check_window,hits + 1,1),window_start = :new_window",
                [':identifier' => $identifier,
                    ':endpoint' => $endpoint,
                    ':window_start' => $windowStart,
                    ':check_window' => $windowStart,
                    ':new_window' => $windowStart ]
            );
            $row = Database::one( " SELECT hits,window_start FROM rate_limits WHERE identifier = :identifier AND endpoint = :endpoint FOR UPDATE",
                [':identifier' => $identifier,
                    ':endpoint' => $endpoint
                ]
            );
            if ($row &&(int) $row['hits'] > $maxHits) {
                Database::rollback();
                header( 'Retry-After: ' . $windowSeconds);
                http_response_code(429);
                echo json_encode([
                    'success' => false,
                    'message' => 'Too many requests. Please slow down.'
                ]);
                exit;
            }
            Database::commit();
        } catch (Throwable $e) {
            Database::rollback();
            throw $e;
        }
    }
    private static function clientIp(): string
    {
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}
?>