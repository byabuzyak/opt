<?php

namespace App\Infrastructure\View;

class View
{
    /**
     * @param string $view
     * @param array $data
     * @return false|string
     */
    public function render(string $view, array $data = []): false|string
    {
        extract($data);
        ob_start();

        include __DIR__ . "/../../../resources/views/{$view}.phtml";

        return ltrim(ob_get_clean());
    }
}