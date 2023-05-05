<?php
namespace App\Controllers;

class AccueilController extends Controller {
    /**
     * Gestion de l'URL /accueil 
     * Deuxième paramètre de l'url vide donc on appelle la fonction index par défaut
     *
     * @return void
     */
    public function index():void
    {
        $this->render("accueil/index");
    }
}