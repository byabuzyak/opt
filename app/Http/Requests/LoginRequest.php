<?php

namespace App\Http\Requests;

use App\Infrastructure\Request\BaseRequest;

final class LoginRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function all(): array
    {
        return [
            'email' => $this->getPost()->get('email'),
            'password' => $this->getPost()->get('password'),
        ];
    }
}