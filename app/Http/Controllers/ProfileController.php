<?php

namespace App\Http\Controllers;

use App\Entity\User;
use App\Infrastructure\View\View;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

final readonly class ProfileController
{
    /**
     * @var User
     */
    private User $user;

    public function __construct(private View $view, private UserRepository $repository, private Request $request)
    {
        $this->user = $this->repository->findByEmail(
            $this->request->getSession()->get('opt_id')
        );
    }

    /**
     * @return void
     */
    public function index(): void
    {
        echo $this->view->render('profile', [
            'user' => $this->user
        ]);
    }
}