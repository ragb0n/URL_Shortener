<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;

require_once("src/Utils/debug.php");
require_once("src/Controller.php");
require_once("src/Exception/AppException.php");

$configuration = require_once("config/Config.php");

$request = [
    'get' => $_GET, //GET to tablica, w której zapisane są wartosci parametrów z URL, np. $_GET['name'] = 'Ala' jeśli w URL jest /?name=Ala
    'post' => $_POST //POST to tablica przetrzymująca wysłane do serwera dane w formie tablicy np. $_POST['imie'] = 'Ala' jeśli w wysłanym formularzu znajdowało się pole name='imie' o wartości 'Ala'
  ];
session_start(); //rozpoczyna sesje

try 
{
  Controller::initConfiguration($configuration); //uruchamia metodę klasy Controller z parametrami ze zmiennej $configuration, tj. z pliku Config.php
  (new Controller($request))->run(); //tworzy nowy pbiekt klasy Controller, do którego przekazuje $request i od razu uruchamia metodą run() klasy Controller
} catch (Exception\ConfigurationException $e)
{
  echo "<h1>Wystapił błąd w aplikacji";
  echo '<h3>Problem z aplikacją, proszę skontaktować się z administratorem</h3>';
} catch (AppException $e) 
{
  echo '<h1>Wystąpił błąd w aplikacji</h1>';
  echo '<h3>' . $e->getMessage() . '</h3>';
} catch (Throwable $e) 
{
  echo '<h1>Wystąpił błąd w aplikacji</h1>';
  dump($e);
}

    