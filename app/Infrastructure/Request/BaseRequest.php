<?php

namespace App\Infrastructure\Request;

use App\Infrastructure\Validator\Validator;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

abstract class BaseRequest
{
    /**
     * @var array
     */
    protected array $errors = [];

    public function __construct(private readonly Validator $validator, private readonly Request $request)
    {
    }

    /**
     * @return InputBag
     */
    public function getPost(): InputBag
    {
        return $this->request->request;
    }

    /**
     * @return InputBag
     */
    public function getQuery(): InputBag
    {
        return $this->request->query;
    }

    /**
     * @return SessionInterface
     */
    public function session(): SessionInterface
    {
        return $this->request->getSession();
    }

    /**
     * @return FlashBagInterface
     */
    public function flash(): FlashBagInterface
    {
        return $this->session()->getFlashBag();
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->request->isMethod('POST');
    }

    /**
     * @param array $rules
     * @return array
     */
    public function validate(array $rules): array
    {
        return $this->validator->validate($rules, $this->all());
    }

    /**
     * @return array
     */
    abstract public function all(): array;
}