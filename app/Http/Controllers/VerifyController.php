<?php

namespace App\Http\Controllers;

use App\Dto\ApproveUserDto;
use App\Http\Requests\VerifyRequest;
use App\Infrastructure\Exception\UserException;
use App\Infrastructure\Validator\Rules\Email;
use App\Infrastructure\Validator\Rules\NotEmpty;
use App\Infrastructure\View\View;
use App\Service\UserService;

final readonly class VerifyController
{
    public function __construct(
        private UserService $userService,
        private VerifyRequest $request,
        private View $view
    ) {
    }

    /**
     * @return void
     */
    public function get(): void
    {
        $errors = $this->request->flash()->get('errors');
        echo $this->view->render('verify', [
            'errors' => $errors,
            'email' => $this->request->getQuery()->get('email'),
        ]);
    }

    /**
     * @return void
     */
    public function post(): void
    {
        $errors = [];
        if ($this->request->isPost()) {
            $data = $this->request->all();
            $errors = $this->request->validate([
                'email' => [
                    new NotEmpty(),
                    new Email(),
                ],
                'code' => [
                    new NotEmpty(),
                ],
            ]);

            if (empty($errors)) {
                try {
                    $this->userService->approveUser(ApproveUserDto::fromArray($data));
                    header('Location: /login');

                    return;
                } catch (UserException $ex) {
                    $errors[] = $ex->getMessage();
                }
            }
        }

        $email = $data['email'] ?? '';
        $this->request->flash()->set('errors', $errors);

        header('Location: /verify?email=' . urlencode($email));
    }
}