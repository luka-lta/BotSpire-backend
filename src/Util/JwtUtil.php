<?php
declare(strict_types=1);

namespace BotSpireBackend\Util;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use JsonException;
use UnexpectedValueException;

class JwtUtil
{
    private string $secretToken = 'gKXKpo4TzpkiYqgi';

    public function encodeToken(array|string $data): string
    {
        $token = [
            'iat' => time(),
            'exp' => time() + 3600, // 1hr
            'data' => $data,
        ];

        return JWT::encode($token, $this->secretToken, 'HS256');
    }

    /**
     * @throws JsonException
     */
    public function decodeToken(string $token): array|string
    {
        try {
            $decode = JWT::decode($token, new Key($this->secretToken, 'HS256'));
            return $decode->data;
        } catch (ExpiredException | SignatureInvalidException $exception) {
            return ReturnMessage::setJsonWithStatus(401, $exception->getMessage());
        } catch (UnexpectedValueException | \Exception $exception) {
            return ReturnMessage::setJsonWithStatus(400, $exception->getMessage());
        }
    }
}