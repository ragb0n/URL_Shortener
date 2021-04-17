<?php

declare(strict_types=1);

namespace App;

require_once("src/Exception/ConfigurationException.php");

use App\Exceptions\ConfigurationException;

require_once("src/Database.php");
require_once("View.php");

class Controller
{
    private const DEFAULT_ACTION = 'landing'; //domyslna akcja/strona

    private static array $configuration = []; //tablica przetrzymująca konfigurację

    private Database $database; //zmienna typu Database
    private array $request; //tablica zawierająca wartości _GET oraz _POST w formie tabeli['get', 'post]
    private View $view; //zmienna typu View

    public static function initConfiguration(array $configuration): void //metoda ustawiająca wartość zmiennej klasy configuration wartościami z pliku Config.php
    {
        self::$configuration = $configuration;
    }

    public function __construct(array $request) //konstruktor tworzący obiekt Database o nazwi
    {
        if (empty(self::$configuration['db'])) {
            throw new ConfigurationException('Configuration error');
          }
        $this->database = new Database(self::$configuration['db']);
        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
        $viewParams = [];
        switch ($this->action()) 
        {
            case 'resolve':
                $page = 'resolve';
                $data = $this->getRequestGet();
                $urlID = (string) ($data['id'] ?? null);
                $url = $this->database->resolveURL($urlID);
                $viewParams = [
                    'url' => $url
                ];
            break;
            case 'shortened':
                $page = 'shortened';
                $data = $this->getRequestGet();
                $viewParams['afterURL'] = $_SESSION['afterURL'] ?? null;
                session_abort();
            break;
            default:
                $page = 'landing';
                $data = $this->getRequestPost();
                if (!empty($data)) {
                    $urlData = [
                        'beforeURL' => $data['beforeURL'],
                        'afterURL' => self::generateRandomString()
                    ];
                    $_SESSION['afterURL'] = $urlData['afterURL'];
                    $this->database->shortenURL($urlData);
                    header('Location: /proj1/?action=shortened');
                }
            break;
        } 
        $this->view->render($page, $viewParams);
    }

    private static function generateRandomString(): string 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function action(): string
    {
      $data = $this->getRequestGet(); //ustawia jako wartośc $data wartośi parametrów zapisanych w GET, tj. w URL, np /?action=show&id=1 zapisane zostanie jako $data['action'=>'show', 'id'=1]
      return $data['action'] ?? self::DEFAULT_ACTION; //zwraca wartość dla parametru actionz URL, jeśli jest pusty zwrócona zostanie wartośc DEFAULT_ACTION, tj. 'landing';
    }

    private function getRequestGet(): array //zwraca znajdujące się w tablicy request pod kluczem 'get' wartości wczesniej zapisane w GET, tj znajdujące się w URL parametry , np /?action to 'action', /?id to 'action'
    {
      return $this->request['get'] ?? [];
    }
  
    private function getRequestPost(): array //zwraca znajdujące się w tablicy request pod kluczem 'post' wartości wczesniej zapisane w POST, tj. zapisane w zmiennej globalnej  POST dane np. formularzy z method=post
    {
      return $this->request['post'] ?? [];
    }
}

