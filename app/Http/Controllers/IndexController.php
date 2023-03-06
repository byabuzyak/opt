<?php

namespace App\Http\Controllers;

use App\Infrastructure\View\View;

final readonly class IndexController
{
    /**
     * @param View $view
     */
    public function __construct(private View $view)
    {
    }

    /**
     * @return void
     */
    public function index(): void
    {
        echo $this->view->render('index');
    }
}