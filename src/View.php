<?php 

declare(strict_types=1);

namespace App;

class View
{
    public function render(string $page, array $params): void //uruchamia lahout.php, tj. szablon strony, z parametrami $page zawierającym nazwę podstrony oraz $params, zawierającym tablicę z m.in. wynikami zapytań do bazy
    {
        require_once("templates/layout.php");
    }
}