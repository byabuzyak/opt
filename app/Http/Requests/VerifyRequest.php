<?php

namespace App\Http\Requests;

use App\Infrastructure\Request\BaseRequest;

final class VerifyRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function all(): array
    {
        return [
            'email' => $this->getPost()->get('email'),
            'code' => $this->getPost()->get('code'),
        ];
    }
}