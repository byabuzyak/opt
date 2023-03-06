<?php

namespace App\Http\Controllers;

use App\Dto\LoginDto;
use App\Http\Requests\LoginRequest;
use App\Infrastructure\Validator\Rules\Email;
use App\Infrastructure\Validator\Rules\NotEmpty;
use App\Infrastructure\View\View;
use App\Service\LoginService;

final readonly class LoginController
{
    public function __construct(
        private LoginRequest $request,
        private View $view,
        private LoginService $loginService
    ) {
    }

    /**
     * @return void
     */
    public function get(): void
    {
        echo $this->view->render('login', [
            'errors' => $this->request->flash()->get('errors'),
        ]);
    }

    /**
     * @return void
     */
    public function post(): void
    {
        $errors = [];
        if ($this->request->isPost()) {
            $errors = $this->request->validate([
                'email' => [new NotEmpty(), new Email()],
                'password' => [new NotEmpty()],
            ]);

            if (empty($errors)) {
                try {
                    $this->loginService->login(LoginDto::fromArray($this->request->all()));

                    header('Location: /profile');
                } catch (\Exception $ex) {
                    $errors[] = $ex->getMessage();
                }
            }
        }

        $this->request->flash()->set('errors', $errors);
        header('Location: /login');
    }
}