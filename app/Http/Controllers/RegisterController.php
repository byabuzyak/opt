<?php

namespace App\Http\Controllers;

use App\Dto\CreateUserDto;
use App\Http\Requests\RegisterRequest;
use App\Infrastructure\Validator\Rules\Email;
use App\Infrastructure\Validator\Rules\NotEmpty;
use App\Infrastructure\View\View;
use App\Service\UserService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

final readonly class RegisterController
{
    public function __construct(
        private RegisterRequest $request,
        private View $view,
        private UserService $userService
    ) {
    }

    /**
     * @return void
     */
    public function get(): void
    {
        echo $this->view->render('register', [
            'errors' => $this->request->flash()->get('errors')
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
                'name' => [new NotEmpty(),],
                'email' => [new NotEmpty(), new Email()],
                'password' => [new NotEmpty()],
            ]);

            if (empty($errors)) {
                try {
                    $this->userService->createUser(CreateUserDto::fromArray($this->request->all()));
                    header('Location: /verify?email=' . urlencode($this->request->getPost()->get('email')));

                    return;
                } catch (UniqueConstraintViolationException) {
                    $errors['email'] = 'Such email is already registered';
                }
            }
        }

        $this->request->flash()->set('errors', $errors);
        header('Location: /register');
    }
}