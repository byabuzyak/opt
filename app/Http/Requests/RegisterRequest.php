<?php

namespace App\Http\Requests;

use App\Infrastructure\Request\BaseRequest;

final class RegisterRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function all(): array
    {
        return [
            'name' => $this->getPost()->get('name'),
            'email' => $this->getPost()->get('email'),
            'password' => $this->getPost()->get('password'),
        ];
    }
}