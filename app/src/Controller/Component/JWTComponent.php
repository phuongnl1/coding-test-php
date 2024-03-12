<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Exception\UnauthorizedException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTComponent extends Component
{
    private $key = 'shhhhh';

    public function generateToken($data)
    {
        return JWT::encode($data, $this->key, 'HS256');
    }

    public function decodeToken($token)
    {
        try {
            if (!$token) throw new UnauthorizedException('Invalid token');
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            throw new UnauthorizedException('Invalid token');
        }
    }
}
