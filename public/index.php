<?php
use App\Autoloader;
use App\Core\Router;

// On définie une constance contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

// On importe l'autoloader
require_once ROOT.'/Autoloader.php';
Autoloader::register();

// On va instancier Router (notre routeur)
$app = new Router();

// On démarre l'application
$app->start();